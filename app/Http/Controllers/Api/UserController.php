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
    public function index_usuarios()
    {
        // Pegar todos os usuarios cadastrados no banco de dados orderby id asc
        $users = User::orderBy('id', 'asc')->get(); 
        
        // Retornar todos os usuários cadastrados
        return UserResource::collection($users);
    }

    public function store_usuario(Request $request)
    {
        // Pegar email do usuário
        $email = $request->email;

        // Verificar se o email já existe no banco de dados
        $user = User::where('email', $email)->first();

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
            'email' => $request->email,
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
        // Pegar usuário pelo id
        $user = User::find($id);

        // Verificar se o usuário existe
        if (!$user) {
            return response()->json([
               'error' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Pegar email do usuário
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

    public function destroy_usuario(string $id)
    {
        // Pegar usuário pelo id
        $user = User::find($id);

        // Verificar se o usuário existe
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
    public function delete_usuario(string $id)
    {
        // Pegar usuário pelo id
        $user = User::find($id);

        // Verificar se o usuário existe
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

}
