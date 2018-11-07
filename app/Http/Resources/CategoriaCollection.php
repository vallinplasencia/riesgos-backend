<?php

namespace App\Http\Resources;

use App\Util\CodigoApp;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoriaCollection extends ResourceCollection
{
    private $codigo;

    /**
     * CategoriaCollection constructor.
     * @param mixed $resource Colleccion de datos a enviar al frontend
     * @param int $codigo Codigo que va a procesar la parte de FrontEnd para verificar
     * si la peticion ocurrio correctamente o existio algun error.
     */
    public function __construct($resource, $codigo = CodigoApp::OK)
    {
        parent::__construct($resource);
        $this->codigo = $codigo;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'codigo' => $this->codigo
        ];
    }
}
