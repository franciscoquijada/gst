<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Meta;

trait Metable
{
    protected $metadataTable;

    //TODO: Centralizar
    protected $validation_errors = [
        'required' => 'Este campo es obligatorio',
        'unique'   => 'Este valor ya se encuentra registrado',
    ];

    public function initializeMetable()
    {
        if(! $this->hasMetadataTable() )
            $this->createMetadataTable();

        $this->appends[] = 'metadata';
        $this->appends[] = 'props';
    }

    public function meta()
    {
        $relation = $this->morphMany( Meta::class, 'metable', 'metable_type', 'metable_id' );

        $wheres = $relation->getQuery()
            ->getQuery()
            ->wheres;

        foreach ( $wheres as &$where )
        {
            if( isset( $where["column"] ) )
                $where["column"] = str_replace(
                    "metas.", 
                    "{$this->metadataTable}.", 
                    $where["column"]
                );
        }

        $relation->getQuery()
            ->from( $this->metadataTable );
        $relation->getRelated()
            ->setTable( $this->metadataTable );
        $relation->getQuery()
            ->getQuery()
            ->wheres = $wheres;

        return $relation;
    }

    public function hasMetadataTable()
    {
        $this->metadataTable = ( isset( $this->customMetadataTable ) && 
            $this->customMetadataTable != '' ) ?
            $this->customMetadataTable : $this->getTable() . '_meta';

        return Schema::hasTable( $this->metadataTable );
    }

    public function createMetadataTable()
    {
        Schema::create( $this->metadataTable, function ( Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->text('value');
            $table->morphs('metable');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function getMeta( $key )
    {
        return $this->meta()
            ->where( 'key',  _to_utf8( $key ) )
            ->whereNotNull('deleted_at')
            ->value( 'value' ) ?? false;
    }

    public function getAllMeta()
    {
        return $this->meta()
            ->pluck( 'value', 'key' ) ?? false;
    }

    public function hasMeta( $key )
    {
        return ( $this->meta()
            ->where( 'key',  _to_utf8( $key ) )
            ->count() > 0 );
    }

    public function clearMeta( $key )
    {
        $this->meta()
            ->where('key',  _to_utf8( $key )  )
            ->delete();

        return true;
    }

    public function setMeta( $key, $value )
    {
        if( $key != '' && $value != '' )
        {
            $this->clearMeta( $key );
            $newMeta = new Meta([
                'key'   => _to_utf8( $key ),
                'value' => _to_utf8( _lower( $value ) )
            ]);
            
            $newMeta->setTable( $this->metadataTable );
            
            $meta = $this->meta()->save($newMeta);

            return ( $meta->count() );
        }
        else
            return false;
    }

    public function setManyMeta( $data )
    {
        if( is_array( $data ) )
            foreach ( $data as $value )
            {
                if( isset( $value['key'], $value['value'] ) && 
                    $value['key']   != '' && 
                    $value['value'] != '' )
                    $this->setMeta( $value['key'], $value['value'] );
            }

        return true;
    }

    public function getPropsAttribute( $value )
    {
       $model = get_class( $this );
       return Meta::select('key','name', 'attr')
            ->where('model', $model )
            ->get()
            ->toArray();
    }

    public function getMetadataAttribute( $value )
    {
        return $this->getAllMeta();
    }

    public function validateMetadata()
    {
        $metadata = [];
        $rules    = [];
        $request  = request()->all();
        $model    = get_class( $this );
        $id       = $this->id ?? NULL;
        $props    = Meta::select('key','name', 'attr')
            ->where('model', $model)
            ->get();

        foreach ( $props AS $prop ) #TODO: Definir tratamiento array y unique
        {
            $value = ( isset( $request['metadata'][ $prop->key ] ) ) ? 
                $request['metadata'][ $prop->key ]: null;

            $rules["metadata.{$prop->key}"] = $prop->rules;

            if( in_array('unique_value', $rules["metadata.{$prop->key}"]) )
            {
                $rules["metadata.{$prop->key}"]   = array_filter( $rules["metadata.{$prop->key}"],
                    function( $value )
                    {
                        return $value !== 'unique_value';
                    });
                $rules["metadata.{$prop->key}"][] = "unique:{$this->metadataTable},value,{$id},metable_id,deleted_at,NULL,metable_type,{$model}";
            }
        }

        $data = \Validator::make($request,$rules,$this->validation_errors )
            ->validate();

        foreach ($data['metadata']  as $key => $value)
        {
            if( !empty( $value ) )
                $metadata[] = [ 
                    'key'   => $key,
                    'value' => $value,
                ];
        }

        return $metadata;
    }
}
