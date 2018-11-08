<?php

use Illuminate\Database\Seeder;

class ProcesoTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            ['proceso'=>'Proceso Operaciones'],
            ['proceso'=>'Proceso Fabricacion'],
            ['proceso'=>'Proceso Armado'],
            ['proceso'=>'Otro Proceso'],
//            ['proceso'=>''],
        ];
        DB::table('procesos')->insert($datos);
    }
}
