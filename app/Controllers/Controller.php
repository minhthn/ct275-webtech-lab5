<?php

declare(strict_types=1);

namespace App\Controllers;

use League\Plates\Engine;

class Controller {
    protected $view;
    public function __construct() {
        $this->view = new Engine(VIEWS_PATH);
    }

    public function sendPage($page, array $data = []) {
        exit($this->view->render($page, $data));
    }

    // save form values to session
    protected function saveFormValues(array $data, array $except = []): void {
        $form = [];
        foreach ($data as $key => $value) {
            if (!in_array($key, $except, true)) {
                $form[$key] = $value;
            }
        }
        $_SESSION['form'] = $form;
    }

    protected function getSavedFormValues() {
        return session_get_once('form', []);
    }
}
