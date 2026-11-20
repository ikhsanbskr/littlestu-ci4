<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/admin');
        }
        return view('admin/login');
    }

    public function attempt()
    {
        $identity = strtolower(trim((string) $this->request->getPost('identity')));
        $password = (string) $this->request->getPost('password');

        $adminModel = new AdminModel();
        $admin      = $adminModel
            ->groupStart()
                ->where('username', $identity)
                ->orWhere('email', $identity)
            ->groupEnd()
            ->first();

        if (! $admin || ! password_verify($password, $admin['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau kata sandi belum sesuai.');
        }

        session()->set([
            'admin_id'       => $admin['id'],
            'admin_name'     => $admin['name'],
            'admin_username' => $admin['username'] ?? $admin['email'],
            'admin_email'    => $admin['email'],
        ]);

        return redirect()->to('/admin')->with('success', 'Selamat datang kembali, ' . $admin['name'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah keluar dari Dashboard Admin.');
    }
}
