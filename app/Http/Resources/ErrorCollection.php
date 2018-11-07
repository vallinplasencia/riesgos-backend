<?php

namespace App\Http\Resources;

use App\Util\CodigoApp;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ErrorCollection extends ResourceCollection
{
    private $codigo;

    public function __construct($resource, $codigo = CodigoApp::SERVER_ERROR)
    {
        parent::__construct($resource);
        $this->codigo = $codigo;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
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
