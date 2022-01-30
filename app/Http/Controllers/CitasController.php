<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Compania;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{

public function index(){
    $citas = Auth::user()->citas;

    return view('citas.index',['citas'=>$citas,]);

}

public function destroy (Cita $cita)

{
    $cita->delete();
    return redirect(route('ver-citas'));

}

public function create ()
{

    return view('citas.create',[
        'compania' => Compania::all(),
        'companias_usuario' => Auth::user()->companias,

    ]);
}


}
