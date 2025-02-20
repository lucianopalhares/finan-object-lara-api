<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Criar usuário novo
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'), 201);
    }

    /**
     * Logar no usuário e pegar o token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Não autorizado'], 401);
    }

    /**
     * Deslogar no usuário
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $token = JWTAuth::parseToken();
            $token->invalidate(true);

            return response()->json(['message' => 'Usuário deslogado com sucesso'], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Erro inesperado'], 500);
        }
    }

    /**
     * Pegar usuário logado
     *
     * @return JsonResponse
     */
    public function getProfile(): JsonResponse
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido'], 400);
        }

        return response()->json(compact('user'));
    }

    /**
     * Pegar notificações do usuário logado
     *
     * @return JsonResponse
     */
    public function notifications(): JsonResponse
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido'], 400);
        }

        $notifications = $user->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'tipo' => 'Pedidos',
                'mensagem' => $notification->data['message'] ?? 'Sem mensagem',
                'lida' => empty($notification->read_at) === true ? 'Não' : 'Sim',
                'data' => \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y'),
            ];
        });

        return response()->json(compact('notifications'));
    }
}
