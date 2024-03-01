<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCursoRequest;
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

    public function store(StoreUpdateCursoRequest $request)
    {
         $data = $request->validated();

         $curso = Curso::create($data);

         return new CursoResource($curso);
    }

    public function show(string $id)
    {
         $curso = Curso::findOrFail($id);

         return new CursoResource($curso);
    }

    public function update(StoreUpdateCursoRequest $request, string $id)
    {
         $data = $request->all();

         $curso = Curso::findOrFail($id);

         $curso->update($data);

         return new CursoResource($curso);
    }
}
