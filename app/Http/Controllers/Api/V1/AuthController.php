<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use App\Http\Requests\V1\RegisterUserRequest;
use App\Http\Requests\V1\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(["data"=> "Credentials Do not match!"]);
            abort(401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token of' . $user->name)->plainTextToken
        ]);
    }




    public function register(RegisterUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Fixed undefined method error
        $token = $user->createToken('Api Token of' . $user->name)->plainTextToken;

        return $this->success([
            "user" => $user,
            "token" => $token
        ]);
    }


    public function logout(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();

        return $this->success([
            "message" => "You have been successfully logged out"
        ]);
    }
}


