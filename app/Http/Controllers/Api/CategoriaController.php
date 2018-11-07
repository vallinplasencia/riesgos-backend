<?php

namespace App\Http\Controllers\Api;

use App\AccesoDatos\CategoriaRepo;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\ErrorCollection;
use App\Models\Categoria;
use App\Util\CodigoApp;
use App\Util\ParamUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CategoriaController extends Controller
{
    private $repo;

    function __construct(CategoriaRepo $repo)
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
        $ordenarPor = $request->query(ParamUrl::PARAM_ORDENAR_POR, 'categoria');
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
            ParamUrl::PARAM_ORDENAR_POR => Rule::in(['categoria']),
            ParamUrl::PARAM_ORDEN => Rule::in(['asc', 'desc']),
            ParamUrl::PARAM_FILTRO => 'string',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }
        $categorias = $this->repo->index(
            $pagina - 1,
            $limite,
            $ordenarPor,
            $orden,
            $filtro);

        return new CategoriaCollection($categorias, CodigoApp::OK);


//        $datos = $request->query();
//        $mensajesErr = [
//            'integer' => 'El campo :attribute debe de ser un número entero.',
//            'gte' => 'El campo :attribute tiene que ser un número mayor o igual a :value.',
//            'in' => 'El campo :attribute puede contener solamente los siguientes valores: :values.',
//        ];
//        $validador = Validator::make($datos, [
//            ParamUrl::PARAM_PAGINA => 'bail|integer|gte:0',
//            ParamUrl::PARAM_LIMITE => 'bail|integer|gte:1',
//            ParamUrl::PARAM_ORDENAR_POR => Rule::in(['categoria']),
//            ParamUrl::PARAM_ORDEN => Rule::in(['asc', 'desc']),
//        ], $mensajesErr);
//
//        if ($validador->fails()) {
//            $errores = collect($validador->errors());
//            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
//        }
//        $categorias = $this->repo->index(
//            $datos[ParamUrl::PARAM_PAGINA],
//            $datos[ParamUrl::PARAM_LIMITE],
//            $datos[ParamUrl::PARAM_ORDENAR_POR],
//            $datos[ParamUrl::PARAM_ORDEN]);
//
//        return new CategoriaCollection($categorias, CodigoApp::OK);


//        $pagina = $request->query(ParamUrl::PARAM_PAGINA, 0);
//        $limite = $request->query(ParamUrl::PARAM_LIMITE, 50);
//        $ordenarPor = $request->query(ParamUrl::PARAM_ORDENAR_POR, 'categoria');
//        $orden = $request->query(ParamUrl::PARAM_ORDEN, 'ASC');

//        $categorias = $this->repo->index($pagina, $limite, $ordenarPor, $orden);
//        return new CategoriaCollection($categorias, CodigoApp::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosCat = $request->only(['categoria']);

        $mensajesErr = [
            'required' => 'Proporcione un valor para el campo :attribute.',
            'string' => 'El campo :attribute puedo contener solo caracteres tradicionales.',
            'max' => 'El campo :attribute puede contener hasta :max caracteres.',
        ];
        $validador = Validator::make($datosCat, [
            'categoria' => 'required|string|max:50',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }
        $categoria = $this->repo->salvar($datosCat);

        if ($categoria) {
            return new CategoriaResource($categoria, CodigoApp::OK);
        } else {
            return new ErrorCollection(collect(['errores' => ['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        return new CategoriaResource($categoria, CodigoApp::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $datosCat = $request->only(['categoria']);

        $mensajesErr = [
            'required' => 'Proporcione un valor para el campo :attribute.',
            'string' => 'El campo :attribute puedo contener solo caracteres tradicionales.',
            'max' => 'El campo :attribute puede contener hasta :max caracteres.',
        ];
        $validador = Validator::make($datosCat, [
            'categoria' => 'required|string|max:50',
        ], $mensajesErr);

        if ($validador->fails()) {
            $errores = collect($validador->errors());
            return new ErrorCollection($errores, CodigoApp::VALIDACION_ERROR);
        }

        $ok = $this->repo->salvar($datosCat, $categoria);

        if ($ok) {
            return new CategoriaResource($categoria, CodigoApp::OK);
        } else {
            return new ErrorCollection(collect(['errores' => ['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Categoria $categoria)
    {
        $rtn = $this->repo->eliminar($categoria);
        if ($rtn === true) {
            return new CategoriaResource($categoria, CodigoApp::OK);
        } elseif ($rtn == 23000) {
            return new ErrorCollection(collect([
                'errores'=>["No se pudo eliminar la categoria {${strtoupper($categoria->categoria)}}. Ya existe un activo que se le asignó esta categoria."]
            ]), CodigoApp::ELIMINACION_ERROR);
        }else{
            return new ErrorCollection(collect(['errores'=>['Ocurrió un error']]), CodigoApp::SERVER_ERROR);
        }
    }
}
