<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Compania;
use App\Models\Especialidad;
use App\Models\Especialista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{

    public function index()
    {
        $citas = Auth::user()->citas;

        return view('citas.index', ['citas' => $citas,]);
    }

    public function destroy(Cita $cita)

    {
        $cita->delete();
        $cita->user_id = null;
        $cita->safe();
        return redirect(route('ver-citas'));
    }




    public function create()
    {

        return view('citas.create', [
            'compania' => Compania::all(),
            'companias_usuario' => Auth::user()->companias,

        ]);
    }
    public function createEspecialidad(Compania $compania)

    {
        return view('citas.create-especialidad', [
            'compania' => $compania,
            'especialidades' => Especialidad::all(),
        ]);
    }

    public function createEspecialista(Compania $compania, Especialidad  $especialidad)
    {
        $especialistas = Especialista::all()->filter(function ($value,$key)use($especialidad,$compania){
            return $value->especialidad == $especialidad && $value->companias->contains($compania);
        });


        return view(
            'citas.create-especialista',
            [
                'compania' => $compania,
                'especialidad' => $especialidad,
                'especialistas' => $especialistas,

            ]
        );
    }

    public function createFechaHora(Compania $compania, Especialidad $especialidad, Especialista $especialista)
    {

        return view('citas.create-fecha-hora', [
            'compania' => $compania,
            'especialidad' => $especialidad,
            'especialista' => $especialista,
            'citas' => $especialista->citas()->where('user_id', null)->get(),
        ]);
    }


    public function createConfirmar(Compania $compania, Cita $cita)
    {
        return view ('cita.create-confirmar',[
                'compania' => $compania,
                    'cita'=>$cita,
        ]);
    }
}
