<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(StoreUserRequest $storeUserRequest)
    {
        try {
            $storeUserRequest->validated($storeUserRequest->all());
            $user = User::create([
                'name' => $storeUserRequest->name,
                'email' => $storeUserRequest->email,
                'password' => Hash::make($storeUserRequest->password),
                'role' => $storeUserRequest->role,
            ]);
            return $this->success([
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }

    public function logIn(LoginUserRequest $loginUserRequest)
    {
        try {
            $loginUserRequest->validated($loginUserRequest->all());

            if (!Auth::attempt($loginUserRequest->only(['email', 'password']))) {
                return $this->error(null, 'Email or Password is incorrect', 401);
            }

            $user = User::where('email', $loginUserRequest->email)->first();

            return $this->success([
                'user' => $user,
                'token' => $user->createToken($user->name . '\'s token', [$user->role])->plainTextToken
            ]);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }

    public function logOut(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            return $this->success(null, "Logout successfully");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
}
