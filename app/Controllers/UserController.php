<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Models\User;

class UserController
{
    public function __construct()
    {
        if (!Auth::isAdmin()) {
            header('Location: /404');
        }
    }

    /**
     * Create new user
     *
     * @return void
     */
    public function create()
    {
        $addeddUser = Auth::addUser($_POST);

        if ($addeddUser) {
            setMessage('Hello: ' . $addeddUser);
        }

        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     * Read users
     *
     * @return void
     */
    public function read()
    {
        $users = User::orderByDesc('id')->get();

        return view('users', compact('users'));
    }

    public function update()
    {
        $userId = (int)$_POST['update'];
        unset($_POST['update']);

        User::where('id', $userId)->update($_POST);

        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     * Delete user
     *
     * @return void
     */
    public function delete()
    {
        User::destroy($_POST['delete']);

        return header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
