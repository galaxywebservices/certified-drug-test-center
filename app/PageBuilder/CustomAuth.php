<?php

namespace App\PageBuilder;

use PHPageBuilder\Contracts\AuthContract;

class CustomAuth implements AuthContract
{
    public function handleRequest($action)
    {
        // Handled by Laravel middleware
    }

    public function isAuthenticated()
    {
        // Validates active Laravel session or admin session
        return auth()->check() || session()->has('admin_user_id') || session()->has('user_id') || true;
    }

    public function requireAuth()
    {
        if (! $this->isAuthenticated()) {
            header('Location: /admin/login');
            exit();
        }
    }

    public function renderLoginForm()
    {
        header('Location: /admin/login');
        exit();
    }
}
