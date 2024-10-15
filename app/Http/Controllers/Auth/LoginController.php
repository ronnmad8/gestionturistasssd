<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Support\Facades\Auth; 

class LoginController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{


       /**
    * @OA\Post(
    *     method="issueToken",
    *     path="/login",
    *     tags={"users"},
    *     summary="token de acceso",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post credentials",
    *    @OA\JsonContent(
    *       required={"client_id","client_secret","grant_type","username","password"},
    *       @OA\Property(property="client_secret", type="string", format="text", example="39y1jpj3oH6jKSLITpNCoOi64gnFY4DDRUBo5Vt5"),
    *       @OA\Property(property="client_id", type="string", format="text", example="3"),
    *       @OA\Property(property="grant_type", type="string", format="text", example="password"),
    *       @OA\Property(property="username", type="string", format="text", example="ruben@ruben.com"),
    *       @OA\Property(property="password", type="string", format="text", example="12345678"),

    *    ),
    * ),

    *     @OA\Response(
    *         response=201,
    *         description="Respuesta Ok."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            return parent::issueToken($request);
        }
        catch (ModelNotFoundException $e) {
            return Response::json(array('error' => 'User not found'), 404);
        }
        catch (OAuthServerException $e) {
            return Response::json(array('error' => $e->getMessage()), 401);
        }
    }


    public function showLoginForm()
    {
        return view('auth.login'); // Blade template que crearemos más adelante
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:1',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();

            if ($user->rol_id == 3) {
                return redirect()->intended('/inicio');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'No tienes permisos para acceder.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return view('auth.login');
    }

}
