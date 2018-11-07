<?php
/**
 * Created by PhpStorm.
 * User: Vallin
 * Date: 28/10/2018
 * Time: 04:13 PM
 */

namespace App\AccesoDatos;


use App\Models\Categoria;
use App\Util\ParamUrl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CategoriaRepo
{
    public function index($pagina = 0, $cantItems = 50, $campoOrdenar = 'categoria', $orden = 'ASC', $filtro = '')
    {
//        $users = DB::table('users')->count();
        $offset = $pagina * $cantItems;

        if ($filtro) {
            $builder = Categoria::where('categoria', 'like', "%$filtro%");
            $totalCategorias = $builder->count();
            $builder = $builder->skip($offset);
        }else{
            $builder = Categoria::skip($offset);
            $totalCategorias = Categoria::count();
        }
        $categorias = $builder
            ->take($cantItems)
            ->orderBy($campoOrdenar, $orden)->get();

        $paginador = new \Illuminate\Pagination\LengthAwarePaginator(
            $categorias,
            $totalCategorias,
            $cantItems,
            $pagina + 1, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => ParamUrl::PARAM_PAGINA
        ]);
        $paginador->appends([
            ParamUrl::PARAM_LIMITE => $cantItems,
            ParamUrl::PARAM_ORDENAR_POR => $campoOrdenar,
            ParamUrl::PARAM_ORDEN => $orden,
            ParamUrl::PARAM_FILTRO => $filtro,
        ]);
        return $paginador;
    }

    public function get($id)
    {
        return Categoria::find(1);
    }

    public function salvar(array $datosNuevaCategoria, Categoria $catActualizar = null)
    {
        if ($catActualizar instanceof Categoria && isset($catActualizar->id)) {
            return $catActualizar->update($datosNuevaCategoria);
        }
        return Categoria::create($datosNuevaCategoria);
    }

    public function eliminar(Categoria $categoria){
        try {
            return $categoria->delete();
        }catch (QueryException $e){
            return $e->getCode();
        }
    }
}