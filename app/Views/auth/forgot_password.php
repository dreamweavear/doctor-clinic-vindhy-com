<?php $this->extend('layouts/auth'); ?>
<?php $this->section('content'); ?>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand-icon"><i class="fas fa-key fa-2x text-white"></i></div>
        <h4>Forgot Password</h4>
        <p>Enter your email or mobile to receive a reset link</p>
    </div>
    <div class="auth-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success mb-3"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mb-3"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <form action="<?= base_url('auth/forgot-password') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="form-label">Email or Mobile Number</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="text" name="identity" class="form-control" placeholder="your@email.com or mobile" required autofocus>
                </div>
            </div>
            <button type="submit" class="btn btn-login"><i class="fas fa-paper-plane me-2"></i> Send Reset Link</button>
        </form>
        <p class="text-center mt-3 mb-0" style="font-size:.825rem;">
            <a href="<?= base_url('auth/login') ?>" style="color:#2563eb;text-decoration:none;"><i class="fas fa-arrow-left me-1"></i>Back to Login</a>
        </p>
    </div>
</div>
<?php $this->endSection(); ?>
