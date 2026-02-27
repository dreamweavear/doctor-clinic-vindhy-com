<?php $this->extend('layouts/auth'); ?>
<?php $this->section('content'); ?>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand-icon">
            <i class="fas fa-hospital-alt fa-2x text-white"></i>
        </div>
        <h4>Clinic OPD System</h4>
        <p>Sign in to your account</p>
    </div>
    <div class="auth-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mb-3"><i class="fas fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success mb-3"><i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <form action="<?= base_url('auth/login') ?>" method="POST" autocomplete="on">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Email or Mobile Number</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="identity" id="identity" class="form-control"
                           placeholder="Enter email or mobile" value="<?= esc(old('identity')) ?>" required autofocus>
                </div>
                <div class="form-text text-muted" style="font-size:.72rem;margin-top:.3rem;">
                    <i class="fas fa-info-circle me-1"></i>You can login with email OR mobile number
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Enter your password" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword"
                            style="border-radius:0 10px 10px 0;border:1.5px solid #e5e7eb;border-left:none;">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input" value="1">
                    <label for="remember_me" class="form-check-label" style="font-size:.825rem;">Remember me</label>
                </div>
                <a href="<?= base_url('auth/forgot-password') ?>" style="font-size:.825rem;color:#2563eb;text-decoration:none;">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Sign In
            </button>
        </form>
        <p class="text-center mt-4 mb-0" style="font-size:.75rem;color:#9ca3af;">&copy; <?= date('Y') ?> Clinic OPD Management System</p>
    </div>
</div>
<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    var p = document.getElementById('password');
    var i = document.getElementById('toggleIcon');
    if (p.type === 'password') { p.type = 'text'; i.classList.replace('fa-eye','fa-eye-slash'); }
    else { p.type = 'password'; i.classList.replace('fa-eye-slash','fa-eye'); }
});
</script>
<?php $this->endSection(); ?>
