<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use Exception;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
         $cursos = Curso::paginate();

         return CursoResource::collection($cursos);
    }

    public function store(Request $request)
    {
         $data = $request->all();

         $curso = Curso::create($data);

         return new CursoResource($curso);
    }
}
