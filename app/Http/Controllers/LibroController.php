<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;

class LibroController extends Controller
{
    public function index()
    {
        $datosLibro = Libro::all();
        return response()->json($datosLibro);
    }

    public function  guardar(Request $request)
    {

        $datosLibro = new Libro;

        $request->file('imagne');

        $datosLibro->Titulo = $request->Titulo;
        $datosLibro->imagne = $request->imagne;

        $datosLibro->save();

        return response()->json($request->file('imagne')->getClientOriginalName());
    }
}
