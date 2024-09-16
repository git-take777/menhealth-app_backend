<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use App\UseCases\LoginUseCase;
use App\UseCases\RegisterUseCase;
use App\UseCases\ProfileUseCase;

use App\Models\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * UserController
 * ユーザーログイン画面
 * ユーザーログイン処理
 * ユーザー新規登録画面
 * ユーザー新規登録処理
 * ユーザーログアウト処理
 * */
class UserController extends Controller
{
    protected $loginUseCase;
    protected $regsiterUseCase;
    protected $profileUseCase;

    public function __construct(LoginUseCase $loginUseCase, RegisterUseCase $regsiterUseCase, ProfileUseCase $profileUseCase)
    {
        $this->loginUseCase = $loginUseCase;
        $this->regsiterUseCase = $regsiterUseCase;
        $this->profileUseCase = $profileUseCase;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ユーザーがログインしているかを確認
        $credentials = $request->only('email', 'password');

        try {
            $this->loginUseCase->execute($credentials['email'], $credentials['password']);
            return response()->json(['message' => 'Login successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * api/registerからのPOSTリクエスト
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 既存ユーザーかチェック
        $userInfo = $this->regsiterUseCase->execute($request->email, $request->password);
        if($userInfo) {
            return response()->json(['message' => 'Register successful'], 200);
        } else {
            return response()->json(['message' => 'Register failed'], 401);
        }
    }

    public function profileStore(Request $request)
    {
        // 既存ユーザーかチェック
        $userInfo = $this->profileUseCase->execute($request);
        if($userInfo) {
            return response()->json(['message' => 'Register successful'], 200);
        } else {
            return response()->json(['message' => 'Register failed'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Auth $auth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auth $auth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthRequest $request, Auth $auth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auth $auth)
    {
        //
    }
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}