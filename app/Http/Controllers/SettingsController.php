<?php

namespace App\Http\Controllers;

use App\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index',[
            'settings' => Setting::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        $setting = Setting::find($id);

        if ( isset( $setting->field['validate'] ) )
        {

            if(is_array( $setting->field['validate']  ) )
            {
                foreach ( $setting->field['validate'] as $value )
                {
                    $patron = "/^new /";
                    if( preg_match( $patron, $value ) )
                    {
                        $object = 'App\Rules\\' . preg_replace( $patron, '', $value);
                        $validate[] = new $object();
                    }
                    else
                    {
                        $validate[] = $value;
                    }
                }
            }
            else
            {
                $validate = $setting->field['validate'];
            }
        }

        $data = Validator::make( $request->all(), [ 'value' => $validate ?? 'required'] );

        //Si existen errores retornamos cada uno de los errores
        if ( count( $data->errors() ) > 0)
            return response()->json([
                'status' => 500, 
                'error'  => $data->errors()
            ]);

        $setting->value = strtolower( $request->value );
        $setting->save();

        log_act(Auth::user()->id, 'Actualizó', 'Se actualizó satisfactoriamente la opción - ' . $setting->name, $request );

        return response()->json(true);
    }
}
