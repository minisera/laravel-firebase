<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;

class SignInController extends Controller
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @param Auth $auth
     * @param Firebase $firebase
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);
        $idToken = $signInResult->data()['idToken'];

        // TODO
        // idトークンの取得と検証を別メソッドにする
        
        try {
            // firebaseから渡されたidトークンを検証する
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
        } catch (InvalidToken $e) {
            return response()->json([
                'error' => 'idトークンが違います'
            ]);
        }

        // ユーザーの固有ID uid を取得する
        $uid = $verifiedIdToken->claims()->get('sub');

        // uidをもとにユーザー情報を取得する
        $user = $this->auth->getUser($uid);

        return response()->json([
            'user' => $user
        ]);
    }
}
