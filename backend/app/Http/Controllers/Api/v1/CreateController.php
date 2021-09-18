<?php
namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Auth;
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    /**
    * @var Auth
    */
    private $auth;

    /**
    * コンストラクタインジェクションで $firebase を用意します
    * @param Auth $auth
    */
    public function __construct(Auth $auth)
    {
      $this->auth = $auth;
    }

    /**
    * シングルアクションコントローラです。
    * @param  Request  $request
    * @return JsonResponse
    */
    public function __invoke(Request $request): JsonResponse
    {
      $email = $request->input('email');
      $password = $request->input('password');
      $user = $this->auth->createUserWithEmailAndPassword($email, $password);
      return response()->json([
          'user' => $user
      ]);
    }
}
