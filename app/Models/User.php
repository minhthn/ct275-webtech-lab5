<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    public const MIN_PASSWORD_LENGTH = 8;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];

    public static function validate(array $data) {
        $errors = [];
        if (! filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email.';
        } elseif (static::where('email', $data['email'])->count() > 0) {
            $errors['email'] = 'Email already in use.';
        }
        if (strlen($data['password']) < static::MIN_PASSWORD_LENGTH) {
            $errors['password'] = 'Password must be at least ' . static::MIN_PASSWORD_LENGTH . ' characters.';
        } elseif ($data['password'] != $data['password_confirmation']) {
            $errors['password'] = 'Password does not match.';
        }
        return $errors;
    }

    public function contacts() {
        return $this->hasMany(Contact::class);
    }
}
