<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $allData = $request->all();
            $allData['password'] = bcrypt($allData['password']);
            $user = User::create($allData);
            $token = $user->createToken('api-application')->accessToken;
            $response = [
                'message' => 'User register successfully',
                'data' => $user,
                'access_token' => $token
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed ' . $e->errorInfo
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } else if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-application')->accessToken;
            $response = [
                'message' => 'Login successfully',
                'data' => $user,
                'access_token' => $token
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            return response()->json(['errors' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
