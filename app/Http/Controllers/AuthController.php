<?php
namespace App\Http\Controllers;
use App\Http\Requests\AuthRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
//    }
//
//    /**
//     * Get a JWT via given credentials.
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function login()
//    {
//        $credentials = request(['email', 'password']);
//
//        if (! $token = auth()->attempt($credentials)) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//
//        return $this->respondWithToken($token);
//    }
//
//    /**
//     * Get the authenticated User.
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
////    public function me()
////    {
////        return response()->json(auth()->user());
////    }
//
//    /**
//     * Log the user out (Invalidate the token).
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function logout()
//    {
//        auth()->logout();
//
//        return response()->json(['message' => 'Successfully logged out']);
//    }
//
//    /**
//     * Refresh a token.
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function refresh()
//    {
////        return response()->json([
////            "success" => true,
////            "payload" => [
////                'access_token' => auth()->refresh(),
////                'token_type' => 'bearer',
////                'expires_in' => auth()->factory()->getTTL() * 60,
////                'user' => auth()->user()
////            ]
////        ]);
//
//        return $this->respondWithToken(auth()->refresh());
//    }
//
//    /**
//     * Get the token array structure.
//     *
//     * @param  string $token
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    protected function respondWithToken($token)
//    {
////        return response()->json([
////            'access_token' => $token,
////            'token_type' => 'bearer',
////            'expires_in' => auth()->factory()->getTTL() * 60,
////
////        ]);
//
//
//        return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
//
//    }


    public function register(AuthRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function me(Request $request)
    {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {

            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
