<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $user = new User();
        $user->createUpdateUser($request, $user);

        $token = $user->createToken('login_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        // Check Email
        $user = User::where('email', $credentials['email'])->first();

        //Check Password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'status' => 'error',
                'message' => 'Bad credentials'
            ], 401);
        }
        //If both cases pass then create token
        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    public function createUser(Request $request)
    {
        $user = new User();
        $user->createUpdateUser($request, $user);

        $response = [
            'status' => true,
            'user' => $user,
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'You have been successfully logged out.'], 200);
    }

    public function getUserDetail(Request $request)
    {
        return $request->user();
    }

    public function getUsers()
    {
        return DB::table('users')->select(['id', 'name', 'email','role', 'created_at'])->orderBy('id', 'DESC')->get();
    }

    public function deleteUser($id)
    {

        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'user deleted',
            'user' => $user,
        ], 201);
    }
}
