<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Meta;

trait Metable
{
    protected $metadataTable;

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

        $relation->getQuery()->from( $this->metadataTable );
        $relation->getQuery()->getQuery()->bindings['where'] = [];
        $relation->getQuery()->getQuery()->wheres = [];

        $relation->getRelated()->setTable( $this->metadataTable );

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
            ->value( 'value' ) ?? false;
    }

    public function getAllMeta()
    {
        return $this->meta()->pluck( 'value', 'key' ) ?? false;
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
                'value' => _to_utf8( $value ) 
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
       return Meta::select('key','name', 'rules')
            ->where('model', $model )
            ->get()
            ->toArray();
    }

    public function getMetadataAttribute( $value )
    {
        return $this->getAllMeta();
    }
}
