<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:api');
    }*/

    protected $server;
    protected $tokens;
    protected $jwt;


    public function __construct(AuthorizationServer $server, TokenRepository $tokens, JwtParser $jwt)
    {
        $this->jwt = $jwt;
        $this->server = $server;
        $this->tokens = $tokens;
    }


    public function login(ServerRequestInterface $request)
    {
        $controller = new AccessTokenController($this->server, $this->tokens, $this->jwt);

        try {
            $request = $request->withParsedBody($request->getParsedBody() +
                [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'gcDJp0VNlMSSbGGCz7mkP2y86xkq46glWKVxBRlj',
                ]);

            return with(new AccessTokenController($this->server, $this->tokens, $this->jwt))
                ->issueToken($request);
        } catch (\Throwable $e) {

            if ($e->getCode() == 400) {

                return response()->json('Invalid Request! Username or Password incorrect', $e->getCode());
            } elseif ($e->getCode() == 401) {

                return response()->json('Credential incorrect! Try again', $e->getCode());
            }
        }
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        
        return response()->json('Logged out successfully', 200);
    }

}
