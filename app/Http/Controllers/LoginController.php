<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','registrasi']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrasi(Request $request){
        $validator = Validator::make($request->all(),[
            'username' => 'required|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::createResponse(422,$validator->messages());
        }
        
        try {
            User::create([
                'username' => $request->username,
                'password' => bcrypt(".9bB=3~".$request->password.".9bB=3~"),
            ]);

            return Response::createResponse(201,'Data Berasil Tersimpan');
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::createResponse(422,'Validasi Gagal',$validator->messages());
        }
        // dd($request);
        try {
            $credentials =
                [
                    'username' => $request->username, 
                    'password' => ".9bB=3~".$request->password.".9bB=3~"
                ]
            ;

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return Response::createResponse(500,$th->getMessage());
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'],200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }
}
