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

    public function  guardar(Request $request) //los parametros recepcionan todo lo que te estan enviando desde el cliente
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

    public function search($id)
    {
        $dataBook = new Libro;
        $datafount = $dataBook->find($id);

        return response()->json($datafount);
    }

    public function remove($id)
    {
        $dataBook = Libro::find($id); //Aca se instancia directamente, es similar a hacer $dataBook = new Libro; con esta se obtiene el id

        if ($dataBook) { //con todo el condicional vamos a validar que si exista un archivo
            $fielRouter = base_path('public') . $dataBook->imagne; //con esto obtenemos la ruta del archivo que esta guardada en la base de datos
            if (file_exists($fielRouter)) {
                unlink($fielRouter); //si existe el archivo en esa ruta se hace el borrado
            }
            $dataBook->delete(); //Aca se hace el borrado de la base de datos
        }
        return response()->json("Registro Borrado");
    }

    public function update(Request $request, $id)
    {
        $dataBook = Libro::find($id); //instanciamos y obtenemos la información por medio del $id

        if ($request->hasFile('imagne')) {

            if ($dataBook) { //con todo el condicional vamos a validar que si exista un archivo
                $fielRouter = base_path('public') . $dataBook->imagne; //con esto obtenemos la ruta del archivo que esta guardada en la base de datos
                if (file_exists($fielRouter)) {
                    unlink($fielRouter); //si existe el archivo en esa ruta se hace el borrado
                }
                $dataBook->delete(); //Aca se hace el borrado de la base de datos
            }

            $fileOriginName = $request->file('imagne')->getClientOriginalName(); //Variable para llamar el nombre del archivo
            $newName = Carbon::now()->timestamp . "_" . $fileOriginName; //Variable para cambiar el nombre der archivo
            $destinationFolder = './upload/'; //Creación dinamica de folder para almacenar los archivos
            $request->file('imagne')->move($destinationFolder, $newName); //mover el archivo enviado a el nuevo folver y llamarlo con el nuevo nombre
            $dataBook->imagne = ltrim($destinationFolder, '.') . $newName; //inserción a baese de datos de columna imagne
            $dataBook->save(); //variable para guardar información en la base de datos
        }

        if ($request->input('Titulo')) { //Aca estamos preguntando si el titulo viene con información
            $dataBook->titulo = $request->input('Titulo'); //recepsion del dato que esta llegando y se almacena al campo de la base de datos
        }

        $dataBook->save(); //guardamos la información recepcionada

        return response()->json("datos actualizados");
    }
}
