<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\SessionGuard;
use App\Models\User;

class RegisterController extends Controller {
    public function __construct() {
        if (SessionGuard::isUserLoggedIn()) {
            redirect('/home');
        }
        parent::__construct();
    }

    public function index() {
        $data = [
            'old' => $this->getSavedFormValues(),
            'errors' => session_get_once('errors'),
        ];
        $this->sendPage('auth/register', $data);
    }

    public function store() {
        $this->saveFormValues($_POST, ['password', 'password_confirmation']);

        $data = $this->filterUserData($_POST);
        $model_errors = User::validate($data);
        if (empty($model_errors)) {
            // data is valid
            $this->createUser($data);
            $messages = [
                'success' => 'User has been created successfully.'
            ];
            redirect('/login', ['messages' => $messages]);
        }

        // data is invalid
        redirect('/register', ['errors' => $model_errors]);
    }

    public function filterUserData(array $data): array {
        return [
            'name' => $data['name'] ?? null,
            'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
            'password' => $data['password'] ?? null,
            'password_confirmation' => $data['password_confirmation'] ?? null,
        ];
    }

    public function createUser($data) {
        // TODO: create `create` method on User model
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
    }
}
