<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Location;
use App\Language;

class LocationsTableSeeder extends Seeder
{
    protected $parents;
    protected $country = false;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        \DB::table('locations')->truncate();

        include( __DIR__ . "/countries.php" );

        if( isset( $payload ) )
        {
            $insert_batch = array_map(function ($carry) use ($now)
            {
                return [
                    'name'       => $carry[1],
                    'parent'     => 0,
                    'level'      => 1,
                    'attr'      => $carry[2],
                    'updated_at' => $now,
                    'created_at' => $now,
                ];
            }, $payload);

            \DB::table( 'locations' )->insert( $insert_batch );
        }

        for ( $i = 1; file_exists( __DIR__ . "/country_{$i}.php"); $i++ )
        {
            include( __DIR__ . "/country_{$i}.php" );

            if( isset( $attr, $country ) )
            {
                $db_country = Location::where([
                    [ 'name', $country ], 
                    [ 'level', 1 ],
                ])->first();

                $db_attr = $db_country->attr;
                $db_attr = array_merge( $db_attr, $attr );

                $db_country->attr = $db_attr;
                $db_country->save();

                $this->country = $db_country->id;
            }

            if( isset( $data, $country ) )
            {

                foreach ( $data as $k => $payload )
                {
                    $insert_batch = array_map(function ($carry) use ($now, $k, $country)
                    {
                        return [
                            'name'       => $carry[1],
                            'parent'     => $this->get_parent( $carry[0], $k, $country ) ?? 0,
                            'level'      => $k,
                            'attr'      => $carry[2] != '' ? $carry[2] : null,
                            'updated_at' => $now,
                            'created_at' => $now,
                        ];
                    }, $payload);

                    \DB::table( 'locations' )->insert( $insert_batch );
                }
            }

            unset( $data, $country );
            $this->country = false;
        }

        //Crear idiomas
        include('languages.php');
        foreach ($idiomas as $idioma)
            Language::create([ 'name' => $idioma ]);
    }

    public function get_parent( $name, $level, $country )
    {
        if( $name == $country )
        {
            if(! $this->country )
            {
                $this->country = Location::where([
                    [ 'name', $country ], 
                    [ 'level', 1 ],
                ])->value('id');
            } 

            return $this->country;
        }
       
        if(! isset( $this->parents[$name] ) )
        {
            $parents = Location::where([
                    [ 'parent', $this->country ],
                ])->pluck('id');

            $this->parents = Location::whereIn('id', $parents)
                ->orWhere(function($query) use ($parents)
                {
                    $query->WhereIn('parent', $parents);
                })
                ->pluck('id', 'name');
        }

        return $this->parents[$name];
    }
}