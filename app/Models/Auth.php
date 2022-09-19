<?php

namespace App\Models;

class Auth
{
    /**
     * Check if user exists by email
     *
     * @param array $user
     * @return mixed
     */
    public static function check($user): mixed
    {
        return User::where('email', $user['email'])->exists();
    }

    public static function isAdmin(): mixed
    {
        return User::where('is_admin', 1)->where('email', $_SESSION['email'])->exists();
    }

    /**
     * Set user session
     *
     * @param mixed $user
     * @return true|void
     */
    public static function loginUser($user): bool
    {
        $user['password'] = sha1($user['password']);

        if (User::where('email', $user['email'])->where('password', $user['password'])->exists()) {
            setAuthSession($user['email']);

            return true;
        }
    }

    /**
     * Create new user
     *
     * @param array $user
     * @return mixed
     */
    public static function register($user): mixed
    {
        $user = self::addUser($user);

        if ($user) {
            setAuthSession($user['email']);
            return $user;
        }
    }

    /**
     * Add new user
     * @param mixed $user
     * @return mixed
     */
    public static function addUser($user): mixed
    {
        if (self::check($user)) {
            setMessage('User already exists');
            return header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        if ($user['name'] && $user['email'] && $user['password']) {
            $user['password'] = sha1($user['password']);
            return User::create($user);
        }

        setMessage('Some fields are empty');
        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function logoutUser()
    {
        // to do
        return setMessage('You are logged out');
    }
}
