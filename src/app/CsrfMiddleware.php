<?php

declare(strict_types=1);

namespace App;

class CsrfMiddleware
{
  public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function csrfInput()
    {
        $token = $this->generateCsrfToken();
        echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    public function validateCsrfToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }
        }
    }
}