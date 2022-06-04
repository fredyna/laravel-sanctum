<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return ResponseFormatter::error(null, 'Unauthorized', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken($request->userAgent())->plainTextToken;

        $data = [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return ResponseFormatter::success($data, 'Berhasil login');
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
