<?php $this->extend('layouts/auth'); ?>
<?php $this->section('content'); ?>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand-icon"><i class="fas fa-lock fa-2x text-white"></i></div>
        <h4>Reset Password</h4>
        <p>Enter your new password below</p>
    </div>
    <div class="auth-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mb-3"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <form action="<?= base_url('auth/reset-password/' . esc($token)) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="p1" class="form-control" placeholder="Min. 6 characters" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleP('p1','i1')" style="border-radius:0 10px 10px 0;border:1.5px solid #e5e7eb;border-left:none;"><i class="fas fa-eye" id="i1"></i></button>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password_confirm" id="p2" class="form-control" placeholder="Repeat password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleP('p2','i2')" style="border-radius:0 10px 10px 0;border:1.5px solid #e5e7eb;border-left:none;"><i class="fas fa-eye" id="i2"></i></button>
                </div>
            </div>
            <button type="submit" class="btn btn-login"><i class="fas fa-save me-2"></i> Reset Password</button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script>
function toggleP(fId,iId){var f=document.getElementById(fId),i=document.getElementById(iId);
if(f.type==='password'){f.type='text';i.classList.replace('fa-eye','fa-eye-slash');}
else{f.type='password';i.classList.replace('fa-eye-slash','fa-eye');}}
</script>
<?php $this->endSection(); ?>
