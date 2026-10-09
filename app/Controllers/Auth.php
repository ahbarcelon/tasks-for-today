<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function login(): string|RedirectResponse
    {
        if (session()->has('user_id')) {
            return redirect()->to(site_url('tasks'));
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function attempt(): RedirectResponse
    {
        $rules = [
            'username' => 'required|max_length[50]',
            'password' => 'required',
        ];

        if (! $this->validateData($this->request->getPost(), $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $user     = (new UserModel())->findByUsername($username);
        $password = (string) $this->request->getPost('password');

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id'   => (int) $user['id'],
            'username'  => $user['username'],
            'full_name' => $user['full_name'],
        ]);

        return redirect()->to(site_url('tasks'))->with('success', 'Welcome back, ' . $user['full_name'] . '.');
    }

    public function logout(): RedirectResponse
    {
        session()->remove(['user_id', 'username', 'full_name']);
        session()->regenerate(true);

        return redirect()->to(site_url('login'))->with('success', 'You have been logged out.');
    }
}
