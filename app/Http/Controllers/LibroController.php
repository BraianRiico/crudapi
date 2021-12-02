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
}
