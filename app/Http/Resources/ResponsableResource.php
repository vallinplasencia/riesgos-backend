<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponsableResource extends JsonResource
{
    private $codigo;

    /**
     * ResponsableResource constructor.
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
                'nombre' => $this->nombre,
                'funcion' => $this->funcion,
                'area' => $this->area,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'fechaAlta' => $this->fechaAlta,
                'fechaBaja' => $this->fechaBaja,
            ],
            'codigo' => $this->codigo
        ];
    }
}
