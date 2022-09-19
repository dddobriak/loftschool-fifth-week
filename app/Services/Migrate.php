<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migrate
{
    public static function createUsersTable()
    {
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('is_admin')->default(0);
            $table->timestamps();
        });

        return setMessage('users table created');
    }

    public static function createPostsTable()
    {
        Capsule::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->mediumText('text');
            $table->bigInteger('user_id');
            $table->timestamps();
        });

        return setMessage('posts table created');
    }

    public static function dropUsersTable()
    {
        Capsule::schema()->dropIfExists('users');

        return setMessage('users table removed');
    }

    public static function dropPostsTable()
    {
        Capsule::schema()->dropIfExists('posts');

        return setMessage('posts table removed');
    }
}
