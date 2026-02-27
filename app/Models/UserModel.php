<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 *
 * Handles all user-related DB operations including authentication,
 * brute-force protection, remember-me tokens, and password reset.
 */
class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'username', 'full_name', 'email', 'mobile', 'password',
        'role', 'is_active', 'degree', 'specialization', 'address',
        'clinic_name', 'remember_token', 'reset_token', 'reset_expiry',
        'last_login', 'created_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'full_name' => 'required|max_length[200]',
        'email' => 'required|valid_email|max_length[200]',
        'mobile' => 'required|max_length[15]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,doctor,receptionist]',
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // ----------------------------------------------------------------
    // Callbacks
    // ----------------------------------------------------------------

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    // ----------------------------------------------------------------
    // Authentication
    // ----------------------------------------------------------------

    /**
     * Find a user by email OR mobile number.
     */
    public function findByEmailOrMobile(string $identity): ?array
    {
        return $this->where('email', $identity)
            ->orWhere('mobile', $identity)
            ->first();
    }

    /**
     * Update last login timestamp.
     */
    public function updateLastLogin(int $userId): void
    {
        $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    // ----------------------------------------------------------------
    // Brute-Force / Login Attempt Limiting
    // ----------------------------------------------------------------

    /**
     * Record a failed login attempt.
     */
    public function recordLoginAttempt(string $ip, string $identity): void
    {
        db_connect()->table('login_attempts')->insert([
            'ip_address' => $ip,
            'identity' => $identity,
            'attempted_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Count failed attempts in the last 15 minutes for an IP.
     */
    public function getAttemptCount(string $ip): int
    {
        $cutoff = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        return (int)db_connect()->table('login_attempts')
            ->where('ip_address', $ip)
            ->where('attempted_at >=', $cutoff)
            ->countAllResults();
    }

    /**
     * Clear all login attempts for an IP on successful login.
     */
    public function clearAttempts(string $ip): void
    {
        db_connect()->table('login_attempts')->where('ip_address', $ip)->delete();
    }

    // ----------------------------------------------------------------
    // Remember Me
    // ----------------------------------------------------------------

    /**
     * Set a remember token for the user.
     */
    public function setRememberToken(int $userId, string $token): void
    {
        $this->update($userId, ['remember_token' => $token]);
    }

    /**
     * Find user by remember token (for auto-login).
     */
    public function findByRememberToken(string $token): ?array
    {
        return $this->where('remember_token', $token)->where('is_active', 1)->first();
    }

    /**
     * Clear the remember token on logout.
     */
    public function clearRememberToken(int $userId): void
    {
        $this->update($userId, ['remember_token' => null]);
    }

    // ----------------------------------------------------------------
    // Password Reset
    // ----------------------------------------------------------------

    /**
     * Set a password reset token.
     */
    public function setResetToken(int $userId, string $token): void
    {
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->update($userId, ['reset_token' => $token, 'reset_expiry' => $expiry]);
    }

    /**
     * Find a user by a valid (non-expired) reset token.
     */
    public function findByResetToken(string $token): ?array
    {
        return $this->where('reset_token', $token)
            ->where('reset_expiry >=', date('Y-m-d H:i:s'))
            ->first();
    }

    /**
     * Clear reset token after use.
     */
    public function clearResetToken(int $userId): void
    {
        $this->update($userId, ['reset_token' => null, 'reset_expiry' => null]);
    }

    // ----------------------------------------------------------------
    // Role-specific Lists
    // ----------------------------------------------------------------

    /**
     * Get all active doctors.
     */
    public function getDoctors(): array
    {
        return $this->where('role', 'doctor')->where('is_active', 1)->findAll();
    }

    /**
     * Get all active receptionists.
     */
    public function getReceptionists(): array
    {
        return $this->where('role', 'receptionist')->where('is_active', 1)->findAll();
    }

    /**
     * Get users by role with optional filters.
     */
    public function getByRole(string $role): array
    {
        return $this->where('role', $role)->findAll();
    }
}
