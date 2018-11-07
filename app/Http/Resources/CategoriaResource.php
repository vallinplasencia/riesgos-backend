<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    private $codigo;

    /**
     * CategoriaResource constructor.
     * @param mixed $resource Datos a enviar al frontend
     * @param int Codigo que va a procesar la parte de FrontEnd para verificar
     * si la peticion ocurrio correctamente o existio algun error.
     */
    public function __construct($resource, $codigo = CodigoApp::OK)
    {
        parent::__construct($resource);
        $this->codigo = $codigo;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' =>[
                'id' => $this->id,
                'categoria' => $this->categoria
            ],
            'codigo' => 200
        ];
    }
}
