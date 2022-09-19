<?php

namespace App\Controllers;

use App\Models\Auth;

class AuthController
{
    /**
     * Create auth view if user isn't authenticated
     *
     * @return void
     */
    public static function create()
    {
        if (!Auth::check($_SESSION)) {
            return view('auth');
        }

        return header('Location: /');
    }

    /**
     * Check if user exists and create user session
     *
     * @return void
     */
    public static function login()
    {
        if (Auth::check($_POST) && Auth::loginUser($_POST)) {
            setMessage('Welcome!');

            return header('Location: /');
        }

        setMessage('User not found or wrong password');

        return header('Location: /auth');
    }

    /**
     * Register new user
     *
     * @return void
     */
    public static function register()
    {
        $registeredUser = Auth::register($_POST);

        if ($registeredUser) {
            setMessage('Hello: ' . $registeredUser);
        }

        return header('Location: /');
    }

    public static function logout()
    {
        // to do
        echo 'logout';
    }
}
