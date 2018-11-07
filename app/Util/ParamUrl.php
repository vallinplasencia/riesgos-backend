<?php
/**
 * Created by PhpStorm.
 * User: Vallin
 * Date: 03/11/2018
 * Time: 01:07 PM
 */

namespace App\Util;


class ParamUrl
{
    //*******************Parametros de la QUERY SQRING *********************//

    /**
     * Numero de la pagina q se va a recuperar
     */
    const PARAM_PAGINA = "_pagina";
    /**
     * Cantidad de elemento q se va a mostrar en el listado
     */
    const PARAM_LIMITE = "_limite";

    /**
     * Campo por el que se a ordenar el resultado
     */
    const PARAM_ORDENAR_POR = "_ordenar";
    /**
     * Orden a aplicar el listado segun el campo ASC o DESC
     */
    const PARAM_ORDEN = "_orden";

    /**
     * Filtro a aplicar soblre los datos
     */
    const PARAM_FILTRO = "_filtro";
}