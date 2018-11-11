<?php

use Illuminate\Database\Seeder;

class ResponsableTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Responsable::class, 15)->create();
    }
}
