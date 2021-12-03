<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use Carbon\Carbon;

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

        if ($request->hasFile('imagne')) {
            $nombreArchivoOriginal = $request->file('imagne')->getClientOriginalName(); //Variable para llamar el nombre del archivo

            $nuevoNombre = Carbon::now()->timestamp . "_" . $nombreArchivoOriginal; //Variable para cambiar el nombre der archivo

            $carpetaDestino = './upload/'; //Creación dinamica de folder para almacenar los archivos

            $request->file('imagne')->move($carpetaDestino, $nuevoNombre); //mover el archivo enviado a el nuevo folver y llamarlo con el nuevo nombre

            $datosLibro->Titulo = $request->Titulo; //inserción a base de datos en columna titulo
            $datosLibro->imagne = ltrim($carpetaDestino, '.') . $nuevoNombre; //inserción a baese de datos de columna imagne

            $datosLibro->save(); //variable para guardar información en la base de datos
        }


        return response()->json($nuevoNombre);
    }
}
