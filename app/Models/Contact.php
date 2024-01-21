<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    protected $table = 'contacts';
    protected $fillable = ['name', 'phone', 'notes', 'user_id'];
    public const MAX_NOTES_LENGTH = 255;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function validate(array $data): array {
        $errors = [];
        if (! $data['name']) {
            $errors['name'] = 'Name cannot be empty';
        }
        $isValidPhone = preg_match(
                '/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/',
                $data['phone']
        );
        if (! $isValidPhone) {
            $errors['phone'] = 'Invalid phone number';
        }
        if (strlen($data['notes']) > static::MAX_NOTES_LENGTH) {
            $errors['notes'] = 'Notes cannot be longer than ' . static::MAX_NOTES_LENGTH . ' characters';
        }
        return $errors;
    }
}
