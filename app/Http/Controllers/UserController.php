<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        try {
            $payload = [
                'name'     => $request->name,
                'password' => Hash::make($request->password),
                'email'    => $request->email,
                'cpf'      => $request->cpf,
                'cnpj'     => $request->cnpj,
                'type'     => $request->type,
            ];

            $user = $this->userRepository->register($payload);

            return response()->json([
                'message' => 'Successfully registered',
                'token'   => $user->createToken('token')->plainTextToken
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            return response($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $payload = [
                'email'    => $request->email,
                'password' => $request->password,
            ];

            $user = $this->userRepository->login($payload);
            
            if (Hash::check($payload['password'], $user->password)) {
                return response()->json([
                    'message' => 'Successfully login',
                    'token'   => $user->createToken('token')->plainTextToken
                ], Response::HTTP_OK);
            }
        } catch (Exception $ex) {
            return response($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
