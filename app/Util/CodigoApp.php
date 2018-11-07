<?php
/**
 * Created by PhpStorm.
 * User: Vallin
 * Date: 29/10/2018
 * Time: 02:47 PM
 */

namespace App\Util;


class CodigoApp
{
    /**
     * Codigo cuando se a ajecutado correctamente la peticion.
     */
    const OK = 200;
    /**
     * Codigo de error cuando existen errores en los datos a validar.
     * Estos datos son entrados por el usuario.
     */
    const VALIDACION_ERROR = 400;

    /**
     * Codigo para un error inesperado.
     * Tambien si no se conoce el error se envia este codigo.
     */
    const SERVER_ERROR = 500;

    /**
     * Codigo de error cuando se trata de eliminar un objeto de la bd q esta referenciado a
     * traves de forign key en otra tabla.
     */
    const ELIMINACION_ERROR = 600;
}