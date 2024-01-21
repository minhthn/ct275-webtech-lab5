<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Models\Contact;

use App\SessionGuard;

class ContactsController extends Controller {
    public function __construct() {
        if (! SessionGuard::isUserLoggedIn()) {
            redirect('/login');
        }
        parent::__construct();
    }

    public function index() {
        $this->sendPage('contacts/index', [
            'contacts' => SessionGuard::user()->contacts, // ??
        ]);
    }

    public function create() {
        $this->sendPage('contacts/create', [
            'errors' => session_get_once('errors'),
            'old' => $this->getSavedFormValues(),
        ]);
    }

    public function store() {
        $contactData = $this->filterContactData($_POST);
        $model_errors = Contact::validate($contactData);
        if (empty($model_errors)) {
            $contact = new Contact();
            $contact->fill($contactData);
            $contact->user()->associate(SessionGuard::user());
            $contact->save();

            redirect('/');  
        }

        // store all form values to session
        $this->saveFormValues($_POST);

        // store errors to session
        redirect('/contacts/create', ['errors' => $model_errors]);
    }

    public function filterContactData(array $data) {
        return [
            'name' => $data['name'] ?? '',
            'phone' => preg_replace('/\D+/', '', $data['phone'] ?? ''),
            'notes' => $data['notes'],
        ];
    }

    public function edit($contactId) {
        $contact = SessionGuard::user()->contacts()->find($contactId);
        if (! $contact) {
            $this->sendNotFound();
        }

        $formValues = $this->getSavedFormValues();
        $data = [
            'errors' => session_get_once('errors'),
            'contact' => (! empty($formValues)
                    ? array_merge($formValues, ['id' => $contactId])
                    : $contact->toArray()),
        ];
        $this->sendPage('contacts/edit', $data);
    }

    public function update($contactId) {
        $contact = SessionGuard::user()->contacts()->find($contactId);
        if (! $contact) {
            $this->sendNotFound();
        }
        $data = $this->filterContactData($_POST);
        $model_errors = Contact::validate($data);
        if (empty($model_errors)) {
            $contact->fill($data);
            $contact->save();
            redirect('/');
        }        
        $this->saveFormValues($_POST);
        redirect("/contacts/edit/{$contactId}", ['errors' => $model_errors]);
    }

    public function delete($contactId) {
        $contact = SessionGuard::user()->contacts()->find($contactId);
        if (! $contact) {
            $this->sendNotFound();
        }

        $contact->delete();
        redirect('/');
    }
}
