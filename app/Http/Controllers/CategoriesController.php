<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = [
            [
                'data'      => 'name',
                'name'      => 'name', 
                'title'     => 'Categoria', 
                'className' => 'text-center text-capitalize'
            ]/*,
            [
                'data'       => 'users_count', 
                'name'       => 'users_count', 
                'title'      => 'Usuarios', 
                'searchable' => false,
                'className'  => 'text-center'
            ]*/,
            [
                'name'      => 'created_at', 
                'title'     => 'Fecha', 
                'className' => 'text-center', 
                'data'      => [ 
                    '_'     => 'created_at.display', 
                    'sort'  => 'created_at.timestamp' 
                ]
            ],
            [
                'data'       => 'action', 
                'name'       => 'acciones', 
                'orderable'  => false, 
                'searchable' => false, 
                'className'  => 'text-center actions'
            ]
        ];
            
        return view('categories.index', [
            'columns'   => $columns
        ]);
    }

    public function list()
    {
        $data = /*( request()->has('trashed') ) ?
            Category::onlyTrashed()->latest():*/
            Category::latest();

        return \DataTables::of( $data )
            ->editColumn('created_at', function($col)
            {
                return [
                    'display'   => ( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ?
                        with( new \Carbon\Carbon($col->created_at) )->format('d/m/Y H:i:s') : '',
                    'timestamp' => ( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ?
                        with( new \Carbon\Carbon($col->created_at) )->timestamp : ''
                    ];
            })
            ->addColumn( 'action', 'groups.partials.buttons' )
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
