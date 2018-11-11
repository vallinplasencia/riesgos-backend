<?php

namespace App\Http\Controllers\Api;

use App\AccesoDatos\ResponsableRepo;
use App\Http\Resources\ResponsableCollection;
use App\Http\Resources\ResponsableResource;
use App\Http\Resources\ErrorCollection;
use App\Models\Responsable;
use App\Util\CodigoApp;
use App\Util\ParamUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResponsableController extends Controller
{
    private $repo;

    function __construct(ResponsableRepo $repo)
    {
        $this->repo = $repo;
    }
    /**
     * Devuelve una lista de responsables y puede incluir una busqueda.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagina = $request->query(ParamUrl::PARAM_PAGINA, 1);
        $limite = $request->query(ParamUrl::PARAM_LIMITE, 50);
        $ordenarPor = $request->query(ParamUrl::PARAM_ORDENAR_POR, 'nombre');
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
            ParamUrl::PARAM_ORDENAR_POR => Rule::in(['nombre', 'funcion', 'area', 'email', 'fechaAlta', 'fechaBaja']),
            ParamUrl::PARAM_ORDEN => Rule::in(['asc', 'desc']),
            ParamUrl::PARAM_FILTRO => 'string',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }
        $responsables = $this->repo->index(
            $pagina - 1,
            $limite,
            $ordenarPor,
            $orden,
            $filtro);

        return new ResponsableCollection($responsables, CodigoApp::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosResp = $request->only(['nombre', 'funcion', 'area', 'direccion', 'email']);

        $mensajesErr = [
            'required' => 'Proporcione un valor para el campo :attribute.',
            'string' => 'El campo :attribute puedo contener solo caracteres tradicionales.',
            'max' => 'El campo :attribute puede contener hasta :max caracteres.',
            'email' => 'El campo :attribute tiene que ser un email válido.',
//            'unique' => 'Ya existe un responsable con el email: :input.',
        ];
        $validador = Validator::make($datosResp, [
            'nombre' => 'required|string|max:100',
            'funcion' => 'required|string|max:70',
            'area' => 'required|string|max:70',
            'direccion' => 'required|string|max:100',
            'email' => 'required|email|max:100',
//            'email' => 'required|email|max:100|unique:responsables',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }
        $responsable = $this->repo->salvar($datosResp);

        if ($responsable) {
            return new ResponsableResource($responsable, CodigoApp::OK);
        } else {
            return new ErrorCollection(collect(['errores' => ['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Responsable  $responsable
     * @return \Illuminate\Http\Response
     */
    public function show(Responsable $responsable)
    {
        return new ResponsableResource($responsable, CodigoApp::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Responsable  $responsable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responsable $responsable)
    {
        $datosResp = $request->only(['nombre', 'funcion', 'area', 'direccion', 'email', 'fechaAlta', 'fechaBaja']);

        $mensajesErr = [
            'required' => 'Proporcione un valor para el campo :attribute.',
            'string' => 'El campo :attribute puedo contener solo caracteres tradicionales.',
            'max' => 'El campo :attribute puede contener hasta :max caracteres.',
            'email' => 'El campo :attribute tiene que ser un email válido.',
            'unique' => 'Ya existe un responsable con el email :value.',
            'date' => 'El campo :attribute tiene que ser una fecha válida.',
            'after_or_equal' => 'El campo :attribute tiene que ser una fecha posterior o igual a la fecha de alta.',
        ];
        $validador = Validator::make($datosResp, [
            'nombre' => 'required|string|max:100',
            'funcion' => 'required|string|max:70',
            'area' => 'required|string|max:70',
            'direccion' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'fechaAlta' => 'required|date',
            'fechaBaja' => 'nullable|date|after_or_equal:fechaAlta'
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }

        $ok = $this->repo->salvar($datosResp, $responsable);

        if ($ok) {
            return new ResponsableResource($responsable, CodigoApp::OK);
        } else {
            return new ErrorCollection(collect(['errores' => ['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Responsable  $responsable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responsable $responsable)
    {
        $rtn = $this->repo->eliminar($responsable);
        if ($rtn === true) {
            return new ResponsableResource($responsable, CodigoApp::OK);
        } elseif ($rtn == 23000) {
            return new ErrorCollection(collect([
                'errores'=>["No se pudo eliminar el responsable {${strtoupper($responsable->nombre)}}. Ya existe un activo que se le asignó este responsable."]
            ]), CodigoApp::ELIMINACION_ERROR);
        }else{
            return new ErrorCollection(collect(['errores'=>['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }
}
