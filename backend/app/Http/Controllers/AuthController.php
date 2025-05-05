<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller {

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function register(UserSaveRequest $request) {

        $request->password = Hash::make($request->password);

        if($user = User::create($request->all())) {

            $token = JWTAuth::fromUser($user);

            return response()->json([ 'user' => $user, 'token' => $token, 'errors' => [], 'msg' => 'Usuário criado com sucesso!' ], 201);
        }

        return response()->json(['errors' => ['error' => 'Erro ao criar o registro']], 404);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {

            return response()->json(['msg' => 'Usuário e/ou senha inválidos.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {

        return response()->json([
            'user' => auth()->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        
        auth('api')->logout();

        return response()->json(['msg' => 'Desconectado com sucesso'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {

        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {

        return response()->json([
            'user' => auth()->user(),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard() {

        return Auth::guard();
    }
}
