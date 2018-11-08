<?php
/**
 * Created by PhpStorm.
 * User: Vallin
 * Date: 28/10/2018
 * Time: 04:13 PM
 */

namespace App\AccesoDatos;


use App\Models\Proceso;
use App\Util\ParamUrl;
use Illuminate\Pagination\Paginator;

class ProcesoRepo
{
    public function index($pagina = 0, $cantItems = 50, $campoOrdenar = 'proceso', $orden = 'ASC', $filtro = '')
    {
//        $users = DB::table('users')->count();
        $offset = $pagina * $cantItems;

        if ($filtro) {
            $builder = Proceso::where('proceso', 'like', "%$filtro%");
            $totalProcesos = $builder->count();
            $builder = $builder->skip($offset);
        }else{
            $builder = Proceso::skip($offset);
            $totalProcesos = Proceso::count();
        }
        $procesos = $builder
            ->take($cantItems)
            ->orderBy($campoOrdenar, $orden)->get();

        $paginador = new \Illuminate\Pagination\LengthAwarePaginator(
            $procesos,
            $totalProcesos,
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
        return Proceso::find(1);
    }

    public function salvar(array $datosNuevaProceso, Proceso $procActualizar = null)
    {
        if ($procActualizar instanceof Proceso && isset($procActualizar->id)) {
            return $procActualizar->update($datosNuevaProceso);
        }
        return Proceso::create($datosNuevaProceso);
    }

    public function eliminar(Proceso $proceso){
        try {
            return $proceso->delete();
        }catch (QueryException $e){
            return $e->getCode();
        }
    }
}