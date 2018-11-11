<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Responsable::class, function (Faker $faker) {

    $nombre = substr($faker->unique()->name, 0, 100);
    //Quitar tildes ennes espacios y otras para el Correo
    $no_permitidas = array(" ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
    $permitidas = array("", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
    $email = mb_strtolower(str_replace($no_permitidas, $permitidas, $nombre));
    $domino = 'midominio.com';
    $email = $email."@$domino";

    $fechaBaja = $faker->boolean ? $faker->dateTimeBetween('tomorrow', '+20 weeks')->format('Y-m-d') : null;

    return [
        'nombre' => $nombre,
        'funcion' => $faker->randomElement(['Jefe A', 'Jefe B', 'Director', 'Jefe de Departamento', 'Jefe economico', 'Jefe de Informatica']),
        'area' => $faker->randomElement(['Area # 1', 'Area # 2', 'General', 'Otra area',]),
        'direccion' => substr($faker->address, 0, 35),
        'email' => $email,
        'fechaAlta' => $faker->dateTimeBetween('-3 weeks')->format('Y-m-d'),
        'fechaBaja' => $fechaBaja
    ];
});
