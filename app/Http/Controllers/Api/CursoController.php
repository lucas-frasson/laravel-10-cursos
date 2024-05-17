<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCursoRequest;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CursoController extends Controller
{
    public function index()
    {
         // Listar todos os cursos orderby id asc
         $cursos = Curso::orderBy('id', 'asc')->get();
     //  $cursos = Curso::paginate();

         return CursoResource::collection($cursos);
    }

    public function store(StoreUpdateCursoRequest $request)
    {

         // Verificar se já existe um curso com o mesmo nome
         $curso = Curso::where('nome', $request->nome)->first();

         if ($curso) {
             return response()->json([
                 'error' => 'Já existe um curso com esse nome!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }

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

         // Condição para atualizar a coluna status
         if ($request->data_fim !== null) 
         {
          Curso::where('id', $id)->update(['status' => 'f']);
         }

         $curso->update($data);

         return new CursoResource($curso);
    }

    public function destroy(string $id)
    {
         $curso = Curso::findOrFail($id);

         $curso->delete();

         return response()->json([], Response::HTTP_NO_CONTENT);
    }

    // deleted_at
    public function delete_curso(string $id)
    {
          $curso = Curso::findOrFail($id);

          if($curso){
               Curso::where('id', $id)->update([
                    'deleted_at' => date('Y-m-d H:i:s')
               ]);
          }

          return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
