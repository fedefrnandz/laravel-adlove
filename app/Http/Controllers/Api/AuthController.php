<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Exception;

class AuthController extends Controller
{
    /**
     * Api Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => [
                    'required',
                    'email',
                ],
                'password' => [
                    'required',
                ],
            ]);
            
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $access_token = $user->createToken('AdloveApp')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'access_token' => $access_token,
                ]);
            }

            return response()->json([
                'message' => 'Email o Contrasena incorrecta',
            ], 401);


        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Api Register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $credentials = $request->validate([
                'name' => [
                    'required',
                ],
                'email' => [
                    'required',
                    'email',
                ],
                'password' => [
                    'required',
                ],
                'c_password' => [
                    'required',
                    'same:password'
                ],
            ]);

            $credentials['password'] = Hash::make($credentials['password']);
            $user = User::create($credentials);

            if ($user) {
                Auth::login($user);
                $access_token = $user->createToken('AdloveApp')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'access_token' => $access_token,
                ]);

            }

            return response()->json([
                'message' => 'Registro Fallido',
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
