<?php

declare(strict_types=1);

namespace App\Controllers;

use App\SessionGuard;

class HomeController extends Controller {
    public function __construct() {
        if (! SessionGuard::isUserLoggedIn()) {
            redirect('/login');
        }
        parent::__construct();
    }

    public function index() {
        $this->sendPage('home');
    }
}
