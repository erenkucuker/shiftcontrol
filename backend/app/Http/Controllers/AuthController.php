<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);    
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' =>  $data['password']]);
        $user->job()->create(['name' => $data['job'], 'description' => $data['description']]);
        $user->assignRole('employee');

        return $this->createdApiResponse([
            'token' => $user->createToken('tokens')->plainTextToken
        ],  'User created successfully');
    }


    public function login(LoginRequest $request)
    {
        
        $data = $request->validated();
        if (!Auth::attempt($data)) 
        {
            return $this->errorApiResponse([], 401, 'Credentials not match');
        }

        return $this->okApiResponse([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'role' => auth()->user()->getRoleNames()->first()
        ], 'Login successfully');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->okApiResponse([], 'Logout Succesfully');
    }
    public function me(Request $request)
    {
        return $request->user();
    }


}
