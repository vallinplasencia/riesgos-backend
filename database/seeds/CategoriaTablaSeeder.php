<?php

use Illuminate\Database\Seeder;

class CategoriaTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['categoria' => 'Servidores Fisicos'],
            ['categoria' => 'Servidores Logicos'],
            ['categoria' => 'Routers Primario'],
            ['categoria' => 'Routers Secundarios'],
            ['categoria' => 'Aplicativos CORE'],
            ['categoria' => 'Aplicativos Seguridad'],
            ['categoria' => 'Aplicativos TI'],
            ['categoria' => 'Procesos'],
            ['categoria' => 'Switch'],
            ['categoria' => 'Enlace'],
//            ['categoria' => ''],
        ];
        DB::table('categorias')->insert($data);
    }
}
