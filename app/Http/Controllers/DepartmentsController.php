<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Exports\DepartmentExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Department;
use App\User;

use Validator;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:modulo de usuarios|listado de departamentos|ver departamentos|crear departamentos|editar departamentos|eliminar departamentos']);
    }

    public function index()
    {
        return view('departments.index', [
            'departments' => Department::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos que los datos cumplan con los requisitos
        $validar = Validator::make(
            $request->all(),
            [
                'name'          => 'required|min:3|string|unique:departments,name,NULL,id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]
        );

        //Si existen errores retornamos cada uno de los errores
        if ( count( $validar->errors() ) > 0)
            return response()->json([
                'status' => 500, 
                'errors' => $validar->errors()
            ]);
        
        $depto = Department::create( $request->all() );

        \PNotify::success('Departamento creado con éxito');

        return response()->json($depto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return [
            'fields' => Department::findOrFail($id),
            'route'  => route( 'departments.update', $id )
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //Validamos que los datos cumplan con los requisitos
        $validar = Validator::make(
            $request->all(),
            [
                'name'          => 'required|min:3|string|unique:departments,name,'.$id.',id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]
        );

        //Si existen errores retornamos cada uno de los errores
        if ( count( $validar->errors() ) > 0)
            return response()->json([
                'status' => 500, 
                'errors' => $validar->errors()
            ]);
                 
        $depto          = Department::findOrFail($id);
        $depto->name    = $request->name;
        $depto->save();

        \PNotify::success('Departamento actualizado con éxito');
             
        return response()->json( $depto );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $depto = Department::findOrFail($id);

        if( $depto != null && $id != 1 )
        {
            $depto->delete();
        
            \PNotify::success('Departamento eliminado con éxito');

            return response()->json($depto);
        }

        return response()->json([
            'status' => 500,
            'errors' => 'Departamento invalido'
        ]);
    }

    public function export()
    {
        return Excel::download(new DepartmentExport, 'departamentos.xlsx');
    }
}
