<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;


class BookController extends Controller
{
    public function index()
    {
        $bookData = Book::all();
        return response()->json($bookData);
    }

    public function  save(Request $request)
    {

        $bookData = new Book();
        $bookData->Titulo = $request->Titulo;
        $bookData->imagne = $request->imagne;

        $bookData->save();

        return response()->json($request);
    }
}
