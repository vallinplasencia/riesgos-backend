<?php

namespace App\Http\Controllers\Api;

use App\AccesoDatos\ProcesoRepo;
use App\Models\Proceso;
use App\Http\Resources\ProcesoCollection;
use App\Http\Resources\ProcesoResource;
use App\Http\Resources\ErrorCollection;
use App\Util\CodigoApp;
use App\Util\ParamUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProcesoController extends Controller
{
    private $repo;

    public function __construct(ProcesoRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagina = $request->query(ParamUrl::PARAM_PAGINA, 1);
        $limite = $request->query(ParamUrl::PARAM_LIMITE, 50);
        $ordenarPor = $request->query(ParamUrl::PARAM_ORDENAR_POR, 'proceso');
        $orden = $request->query(ParamUrl::PARAM_ORDEN, 'ASC');
        $filtro = $request->query(ParamUrl::PARAM_FILTRO, '');

        $mensajesErr = [
            'integer' => 'El campo :attribute debe de ser un número entero.',
            'gte' => 'El campo :attribute tiene que ser un número mayor o igual a :value.',
            'in' => 'El campo :attribute puede contener solamente los siguientes valores: :values.',
            'string' => 'El campo :attribute puede contener solamente caracteres permitidos.',
        ];
        $validador = Validator::make($request->query(), [
            ParamUrl::PARAM_PAGINA => 'bail|integer|gte:1',
            ParamUrl::PARAM_LIMITE => 'bail|integer|gte:1',
            ParamUrl::PARAM_ORDENAR_POR => Rule::in(['proceso']),
            ParamUrl::PARAM_ORDEN => Rule::in(['asc', 'desc']),
            ParamUrl::PARAM_FILTRO => 'string',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }
        $procesos = $this->repo->index(
            $pagina - 1,
            $limite,
            $ordenarPor,
            $orden,
            $filtro);

        return new ProcesoCollection($procesos, CodigoApp::OK);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosProc = $request->only(['proceso']);

        $mensajesErr = [
            'required' => 'Proporcione un valor para el campo :attribute.',
            'string' => 'El campo :attribute puedo contener solo caracteres tradicionales.',
            'max' => 'El campo :attribute puede contener hasta :max caracteres.',
        ];
        $validador = Validator::make($datosProc, [
            'proceso' => 'required|string|max:50',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }
        $proceso = $this->repo->salvar($datosProc);

        if ($proceso) {
            return new ProcesoResource($proceso, CodigoApp::OK);
        } else {
            return new ErrorCollection(collect(['errores' => ['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Proceso $proceso)
    {
        return new ProcesoResource($proceso, CodigoApp::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proceso $proceso)
    {
        $datosProc = $request->only(['proceso']);

        $mensajesErr = [
            'required' => 'Proporcione un valor para el campo :attribute.',
            'string' => 'El campo :attribute puedo contener solo caracteres tradicionales.',
            'max' => 'El campo :attribute puede contener hasta :max caracteres.',
        ];
        $validador = Validator::make($datosProc, [
            'proceso' => 'required|string|max:50',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }

        $ok = $this->repo->salvar($datosProc, $proceso);

        if ($ok) {
            return new ProcesoResource($proceso, CodigoApp::OK);
        } else {
            return new ErrorCollection(collect(['errores' => ['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proceso $proceso)
    {
        $rtn = $this->repo->eliminar($proceso);
        if ($rtn === true) {
            return new ProcesoResource($proceso, CodigoApp::OK);
        } elseif ($rtn == 23000) {
            return new ErrorCollection(collect([
                'errores'=>["No se pudo eliminar la proceso {${strtoupper($proceso->proceso)}}. Ya existe un activo que se le asignó esta proceso."]
            ]), CodigoApp::ELIMINACION_ERROR);
        }else{
            return new ErrorCollection(collect(['errores'=>['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }
}
