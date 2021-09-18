<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
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
        $id_token = $signInResult->data()['idToken'];
        return response()->json([
            'idToken' => $id_token
        ]);
    }
}
