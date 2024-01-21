<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\SessionGuard;
use App\Models\User;

class LoginController extends Controller {
    public function __construct() {
        parent::__construct();
    }


    public function index() {
        if (SessionGuard::isUserLoggedIn()) {
            redirect('/home');
        }
        $data = [
            'message' => session_get_once('message'),
            'old' => $this->getSavedFormValues(),
            'errors' => session_get_once('errors'),
        ];
        $this->sendPage('auth/login', $data);
    }

    public function store() {
        $userCredentials = $this->filterUserCredentials($_POST);

        $errors = [];
        $user = User::where('email', $userCredentials['email'])->first();
        if (! $user) {
            // user does not exist.
            $errors['email'] = 'Invalid email or password.'; 
        } else if (SessionGuard::login($user, $userCredentials)) {
            // login success
            redirect('/home');
        } else {
            // wrong credentials
            $errors[] = 'Invalid email or password.';
        }

        // wrong credentials
        $this->saveFormValues($_POST, except: ['password']);
        redirect('/login', ['errors' => $errors]);
    }

    public function logoutUser() {
        SessionGuard::logout();
        redirect('/home');
    }

    public function filterUserCredentials(array $data) {
        return [
            'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
            'password' => $data['password'] ?? null,
        ];
    }
}
