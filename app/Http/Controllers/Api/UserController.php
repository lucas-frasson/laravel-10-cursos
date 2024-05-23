<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
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
               'message' => 'Já existe um usuário cadastrado com esse email!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $email_verified_at = now();
        $password = Hash::make('password');
        $remember_token = Str::random(10);

        // Criar novo usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $email_verified_at,
            'password' => $password,
            'remember_token' => $remember_token,
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
               'message' => 'Usuário não encontrado!'
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
               'message' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
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
               'message' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Deletar usuário
        $user->delete();

        // Retornar mensagem de sucesso
        return response()->json([
           'message' => 'Usuário deletado com sucesso!'
        ], Response::HTTP_NO_CONTENT);
    }

    public function delete_usuario(string $id)
    {
        // Pegar usuário pelo id
        $user = User::find($id);

        // Verificar se o usuário existe
        if (!$user) {
            return response()->json([
               'message' => 'Usuário não encontrado!'
            ], Response::HTTP_NOT_FOUND);
        }

        // Deletar usuário
        User::where('id', $id)->update([
                'deleted_at' => date('Y-m-d H:i:s')
        ]);

        // Retornar mensagem de sucesso
        return response()->json([
           'message' => 'Usuário deletado com sucesso!'
        ], Response::HTTP_NO_CONTENT);
    }

}
