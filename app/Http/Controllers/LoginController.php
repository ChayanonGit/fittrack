<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends Controller
{
    //


    function showLoginForm(): View
    {
        return view('logins.form');
    }

    function logout(): RedirectResponse
    {

        Auth::logout();

        session()->invalidate();

        // regenerate CSRF token

        session()->regenerateToken();

        return redirect()->route('home');
    }
    function authenticate(ServerRequestInterface $request): RedirectResponse
    {

        // get credentials from user.

        // authenticate by using method attempt()

        // if cannot authenticate redirect back to loginForm with error message.

        $validator = Validator::make(

            $request->getParsedBody(),

            [

                'email' => 'required',

                'password' => 'required',

            ],
        );

        if (

            $validator->passes() &&

            Auth::attempt(

                $validator->safe()->only(['email', 'password']),

            )

        ) {

            // regenerate the new session ID

            session()->regenerate();

            // redirect to the requested URL or

            // to route products.list if does not specify

            return redirect()->intended(route('home'));
        }
        $validator

            ->errors()

            ->add(

                'credentials',

                'The provided credentials do not match our records.',

            );

        return redirect()

            ->back()

            ->withErrors($validator);
    }
}
