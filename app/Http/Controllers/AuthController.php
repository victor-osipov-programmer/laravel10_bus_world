<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    function login(Request $request) {
        $data = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($data)) {
            return response([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'errors' => [
                        'phone' => [
                            'Неверный номер телефона или пароль'
                        ]
                    ],
                ]
            ], 401);
        }

        $new_token = $request->user()->createToken('name');

        return [
            'data' => [
                'token' => $new_token->plainTextToken
            ]
        ];
    }
}
