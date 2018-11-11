<?php
/**
 * Created by PhpStorm.
 * User: Vallin
 * Date: 28/10/2018
 * Time: 04:13 PM
 */

namespace App\AccesoDatos;


use App\Models\Responsable;
use App\Util\ParamUrl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ResponsableRepo
{
    public function index($pagina = 0, $cantItems = 50, $campoOrdenar = 'responsable', $orden = 'ASC', $filtro = '')
    {
//        $users = DB::table('users')->count();
        $offset = $pagina * $cantItems;

        if ($filtro) {
            $builder = Responsable::where('nombre', 'like', "%$filtro%")
                ->orWhere('area', 'like', "%$filtro%");
            $totalResponsable = $builder->count();
            $builder = $builder->skip($offset);
        }else{
            $builder = Responsable::skip($offset);
            $totalResponsable = Responsable::count();
        }
        $responsables = $builder
            ->take($cantItems)
            ->orderBy($campoOrdenar, $orden)->get();

        $paginador = new \Illuminate\Pagination\LengthAwarePaginator(
            $responsables,
            $totalResponsable,
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
        return Responsable::find(1);
    }

    public function salvar(array $datosNuevoResponsable, Responsable $respActualizar = null)
    {
        if ($respActualizar instanceof Responsable && isset($respActualizar->id)) {
            return $respActualizar->update($datosNuevoResponsable);
        }
        $datosNuevoResponsable['fechaAlta'] = (new \DateTime('now'))->format('Y-m-d');
        return Responsable::create($datosNuevoResponsable);
    }

    public function eliminar(Responsable $responsable){
        try {
            return $responsable->delete();
        }catch (QueryException $e){
            return $e->getCode();
        }
    }
}