<?php

declare(strict_types=1);

namespace App;

use App\Models\User;

class SessionGuard {
    protected static $user;

    public static function login(User $user, array $credentials): bool {
        $verified = password_verify($credentials['password'], $user->password);
        if ($verified) {
            $_SESSION['user_id'] = $user->id;
        }
        return $verified;
    }

    public static function user(): User {
        if (! static::$user && static::isUserLoggedIn()) {
            static::$user = User::find($_SESSION['user_id']);
        }
        return static::$user;
    }

    public static function logout(): void {
        static::$user = null;
        session_unset();
        session_destroy();
    }

    public static function isUserLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
}
