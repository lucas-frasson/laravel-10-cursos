<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index_usuarios(Request $request)
    {

        // Pegar email do usuário
        $email = $request->email;

        // Consultando usuário no banco de dados
        $user = User::where('email', $email)->first();

        // Verificar se o usuário existe
        if (!$user) {
            return response()->json([
                'error' => 'Usuário não encontrado!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Verificar se o usuário é admin
        if ($user->type != 'admin') {
            return response()->json([
                'error' => 'Sem permissão!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Pegando o nome ou e-mail e o tipo do usuário pesquisado
        $nome_email = $request->nome_email;
        $type = $request->type;

        // Inicia a query
        $query = User::query();

        // Aplica filtro de nome ou e-mail, se existir
        if (!empty($nome_email)) {
            $query->where('name', 'like', "%{$nome_email}%")
                ->orWhere('email', 'like', "%{$nome_email}%");
        }
        
        // Aplica filtro de tipo, se existir
        if (!empty($type)) {
            $query->where('type', $type);
        }

        // Ordena os resultados orderby id asc
        $users = $query->orderBy('id', 'asc')->get();
        
        // Retornar todos os usuários cadastrados
        return UserResource::collection($users);
    }

    public function store_usuario(Request $request)
    {

         // Pegar email do usuário
         $email = $request->email;

         // Consultando usuário no banco de dados
         $isAdmin = User::where('email', $email)->first();
 
         // Verificar se o usuário existe
         if (!$isAdmin) {
             return response()->json([
                 'error' => 'Usuário não encontrado!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }
 
         // Verificar se o usuário é admin
         if ($isAdmin->type != 'admin') {
             return response()->json([
                 'error' => 'Sem permissão!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }

        // Pegar email do novo usuário
        $email_usuario = $request->email_usuario;

        // Verificar se o email já existe no banco de dados
        $user = User::where('email', $email_usuario)->first();

        // Verificar se o usuário existe
        if ($user) {
            return response()->json([
               'error' => 'Já existe um usuário cadastrado com esse email!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Criando senha com hash
        $password = Hash::make('password');

        // Criar novo usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email_usuario,
            'type' => $request->type,
            'email_verified_at' => now(),
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        // Retornar usuário criado
        return new UserResource($user);
    }

    public function show_usuario(string $id)
    {
        // Pegar usuário pelo id
        $user = User::find($id);

        // Verificar se o usuário existe
        if (!$user) {
            return response()->json([
               'error' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Retornar usuário
        return new UserResource($user);
    }

    public function update_usuario(Request $request, string $id)
    {

         // Pegar email do usuário
         $email_usuario = $request->email_usuario;

         // Consultando usuário no banco de dados
         $isAdmin = User::where('email', $email_usuario)->first();
 
         // Verificar se o usuário existe
         if (!$isAdmin) {
             return response()->json([
                 'error' => 'Usuário não encontrado!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }
 
         // Verificar se o usuário é admin
         if ($isAdmin->type != 'admin') {
             return response()->json([
                 'error' => 'Sem permissão!'
             ], Response::HTTP_UNPROCESSABLE_ENTITY);
         }

        // Pegar usuário editado pelo id
        $user = User::find($id);

        // Verificar se o usuário editado existe
        if (!$user) {
            return response()->json([
               'error' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Pegar email do usuário editado
        $email = $request->email;

        // Verificar se o email já existe no banco de dados em um usuário com o id diferente
        $existingUser = User::where('email', $email)->where('id', '!=', $id)->first();

        // Verificar se existe um usuário com o mesmo email
        if ($existingUser) {
            return response()->json([
               'error' => 'Já existe um usuário cadastrado com esse email!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Atualizar usuário
        $user->update($request->all());

        // Retornar usuário atualizado
        return new UserResource($user);
    }

    public function destroy_usuario(string $id, Request $request)
    {

        // Pegar email do usuário
        $email = $request->email;

        // Consultando usuário no banco de dados
        $isAdmin = User::where('email', $email)->first();

        // Verificar se o usuário existe
        if (!$isAdmin) {
            return response()->json([
                'error' => 'Usuário não encontrado!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Verificar se o usuário é admin
        if ($isAdmin->type != 'admin') {
            return response()->json([
                'error' => 'Sem permissão!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Pegar usuário deletado pelo id
        $user = User::find($id);

        // Verificar se o usuário deletado existe
        if (!$user) {
            return response()->json([
               'error' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Deletar usuário
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    // deleted_at
    public function delete_usuario(string $id, Request $request)
    {

        // Pegar email do usuário
        $email = $request->email;

        // Consultando usuário no banco de dados
        $isAdmin = User::where('email', $email)->first();

        // Verificar se o usuário existe
        if (!$isAdmin) {
            return response()->json([
                'error' => 'Usuário não encontrado!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Verificar se o usuário é admin
        if ($isAdmin->type != 'admin') {
            return response()->json([
                'error' => 'Sem permissão!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Pegar usuário deletado pelo id
        $user = User::find($id);

        // Verificar se o usuário deletado existe
        if (!$user) {
            return response()->json([
               'error' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Deletar usuário
        User::where('id', $id)->update([
                'deleted_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function verifica_admin(Request $request)
    {

        // Pegar email do usuário
        $email = $request->email;

        // Verificar se o email já existe no banco de dados
        $user = User::where('email', $email)->first();

        // Verificar se o usuário existe
        if (!$user) {
            return response()->json([
               'error' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Verificar se o usuário é administrador
        if ($user->type != 'admin') {
            return response()->json([
               'error' => 'Usuário não é administrador!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Retornar true
        return Response::HTTP_OK;
    }
}
