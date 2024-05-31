<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCursoRequest;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CursoController extends Controller
{
    public function index(Request $request)
    {     
          // Pegar email do usuário
          $email = $request->email;

          // Procurar o id do usuário com esse email
          $user = User::where('email', $email)->first();

          // Pegar o id do usuário
          $id = $user->id;

          // Pegando o que vier do input pesquisar e o status do curso
          $pesquisar = $request->pesquisar;
          $status = $request->status;

          // Inicia a query
          $query = Curso::query()->where('id_user', $id);

          // Aplica filtro de nome, plataforma, data_inicio e data_fim, se existir
          if (!empty($pesquisar)) {
               $query->where('nome', 'like', "%{$pesquisar}%")
                    ->orWhere('plataforma', 'like', "%{$pesquisar}%")
                    ->orWhere('data_inicio', 'like', "%{$pesquisar}%")
                    ->orWhere('data_fim', 'like', "%{$pesquisar}%");
          }

          // Aplica filtro de status, se existir
          if (!empty($status)) {
               $query->where('status', $status);
          }

          // Ordena os resultados orderby id asc
          $cursos = $query->orderBy('id', 'asc')->get();

          // Retornar todos os cursos do usuário
          return CursoResource::collection($cursos);
    }

    public function store(Request $request)
    {
         // Pegar email do usuário
         $email = $request->email;

         // Procurar o id do usuário com esse email
         $user = User::where('email', $email)->first();

         // Pegar o id do usuário
         $id_user = $user->id;

         // Verificar se já existe um curso com o id do usuário com o mesmo nome
         $curso = Curso::where('id_user', $id_user)->where('nome', $request->nome)->first();

         if ($curso) {
             return response()->json([
                 'error' => 'Já existe um curso com esse nome!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }

         $curso = Curso::create([
           'id_user' => $id_user,
           'nome' => $request->nome,
           'plataforma' => $request->plataforma,
           'data_inicio' => $request->data_inicio,
         ]);

         return new CursoResource($curso);
    }

    public function show(string $id)
    {
         $curso = Curso::findOrFail($id);

         return new CursoResource($curso);
    }

    public function update(Request $request, string $id)
    {
     
          // Pegar email do usuário
         $email = $request->email;

         // Procurar o id do usuário com esse email
         $user = User::where('email', $email)->first();

         // Pegar o id do usuário
         $id_user = $user->id;

         $data = $request->all();

         $curso = Curso::findOrFail($id);

         // Verificar se o nome do curso já existe no banco de dados em um curso com o id diferente e id do usuário igual
         $curso_nome = Curso::where('id_user', '=', $id_user)
                              ->where('nome', $request->nome)
                              ->where('id', '!=', $id)->first();

         if ($curso_nome) {
             return response()->json([
                 'error' => 'Já existe um curso com esse nome!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }
         
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
