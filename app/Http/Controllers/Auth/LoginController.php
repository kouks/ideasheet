<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if ($this->attemptLogin($request)) {
            return response()
                ->json(auth()->user(), 200);
        }

        return response()
            ->json(['error' => 'Invalid credentials.'], 422);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return bool
     */
    protected function attemptLogin(LoginRequest $request)
    {
        return auth()->guard()->attempt(
            $request->only($this->username(), 'password'), $request->filled('remember')
        );
    }

    /**
     * The username field name.
     *
     * @return string
     */
    protected function username()
    {
        return 'email';
    }
}
