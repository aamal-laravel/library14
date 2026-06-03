<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ِِAuthController extends Controller
{
    /**
     * 
     */
    function register(Request $request)
    {
        $user = User::create($request->all());
        $token = $user->createToken('api token');
        return apiSuccess("تم إنشاء الحساب", [
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }
    function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password))
            return apiFail("معلومات الدخول غير صحيحة", Response::HTTP_UNPROCESSABLE_ENTITY);
        $token = $user->createToken('api token');

        return apiSuccess("أهلا بك  ", [
            'user' => $user,
            'token' => $token->plainTextToken,
        ]);
    }

    function logout(Request $request)
    {

        // $user = Auth::user();
        // $user = auth()->user();
        $user =  $request->user();
        $user->currentAccessToken()->delete();
        return apiSuccess("تم تسجيل الخروج");
    }
}
