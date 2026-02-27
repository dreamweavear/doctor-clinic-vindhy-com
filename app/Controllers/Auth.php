<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Auth Controller
 *
 * Handles: login (email/mobile), logout, forgot password, reset password.
 * Security: brute-force limiting (5 attempts / 15 min), bcrypt, CSRF.
 */
class Auth extends BaseController
{
    protected UserModel $userModel;
    const MAX_ATTEMPTS = 5;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ----------------------------------------------------------------
    // Login
    // ----------------------------------------------------------------

    public function login()
    {
        // Already logged in?
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        if ($this->request->getMethod() === 'POST') {
            return $this->processLogin();
        }

        return view('auth/login', ['title' => 'Login | Clinic OPD']);
    }

    private function processLogin()
    {
        $ip = $this->request->getIPAddress();
        $attemptCount = $this->userModel->getAttemptCount($ip);

        // Brute-force check
        if ($attemptCount >= self::MAX_ATTEMPTS) {
            return redirect()->back()->withInput()
                ->with('error', 'Too many failed login attempts. Please wait 15 minutes and try again.');
        }

        $identity = trim($this->request->getPost('identity'));
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember_me');

        $rules = [
            'identity' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Email/Mobile and password are required.');
        }

        $user = $this->userModel->findByEmailOrMobile($identity);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->userModel->recordLoginAttempt($ip, $identity);
            $remaining = self::MAX_ATTEMPTS - ($attemptCount + 1);
            $msg = "Invalid credentials. {$remaining} attempt(s) remaining.";
            return redirect()->back()->withInput()->with('error', $msg);
        }

        if (!$user['is_active']) {
            return redirect()->back()->withInput()
                ->with('error', 'Your account is inactive. Please contact administrator.');
        }

        // Successful login — clear attempts, set session
        $this->userModel->clearAttempts($ip);
        $this->userModel->updateLastLogin($user['id']);

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true,
        ]);

        // Remember me
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->userModel->setRememberToken($user['id'], $token);
            $cookieExpiry = time() + (30 * 24 * 60 * 60); // 30 days
            $response = $this->response;
            helper('cookie');
            set_cookie('remember_me', $token, $cookieExpiry);
        }

        return redirect()->to(base_url('dashboard'));
    }

    // ----------------------------------------------------------------
    // Logout
    // ----------------------------------------------------------------

    public function logout()
    {
        $userId = session()->get('user_id');
        if ($userId) {
            $this->userModel->clearRememberToken($userId);
        }

        session()->destroy();
        helper('cookie');
        delete_cookie('remember_me');

        return redirect()->to(base_url('auth/login'))->with('success', 'You have been logged out.');
    }

    // ----------------------------------------------------------------
    // Forgot Password
    // ----------------------------------------------------------------

    public function forgotPassword()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        if ($this->request->getMethod() === 'POST') {
            $identity = trim($this->request->getPost('identity'));

            if (empty($identity)) {
                return redirect()->back()->with('error', 'Please enter your email or mobile number.');
            }

            $user = $this->userModel->findByEmailOrMobile($identity);
            // Always show same message to prevent user enumeration
            $successMsg = 'If that account exists, a password reset link has been sent.';

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $this->userModel->setResetToken($user['id'], $token);

                // Send email
                $email = \Config\Services::email();
                $email->setTo($user['email']);
                $email->setSubject('Password Reset - Clinic OPD System');
                $resetLink = base_url("auth/reset-password/{$token}");
                $body = "Hello {$user['full_name']},\n\n"
                    . "Click the link below to reset your password (valid for 1 hour):\n\n"
                    . $resetLink . "\n\n"
                    . "If you did not request this, please ignore this email.\n\n"
                    . "Clinic OPD System";
                $email->setMessage($body);
                $email->send();
            }

            return redirect()->back()->with('success', $successMsg);
        }

        return view('auth/forgot_password', ['title' => 'Forgot Password | Clinic OPD']);
    }

    // ----------------------------------------------------------------
    // Reset Password
    // ----------------------------------------------------------------

    public function resetPassword($token)
    {
        $user = $this->userModel->findByResetToken($token);

        if (!$user) {
            return redirect()->to(base_url('auth/login'))
                ->with('error', 'Invalid or expired password reset link.');
        }

        if ($this->request->getMethod() === 'POST') {
            $password = $this->request->getPost('password');
            $passwordConfirm = $this->request->getPost('password_confirm');

            if (strlen($password) < 6) {
                return redirect()->back()->with('error', 'Password must be at least 6 characters.');
            }

            if ($password !== $passwordConfirm) {
                return redirect()->back()->with('error', 'Passwords do not match.');
            }

            $this->userModel->update($user['id'], ['password' => $password]);
            $this->userModel->clearResetToken($user['id']);

            return redirect()->to(base_url('auth/login'))
                ->with('success', 'Password reset successfully. Please login.');
        }

        return view('auth/reset_password', [
            'title' => 'Reset Password | Clinic OPD',
            'token' => $token,
        ]);
    }
}
