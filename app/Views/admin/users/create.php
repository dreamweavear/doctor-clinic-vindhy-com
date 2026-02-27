<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-user-plus me-2 text-primary"></i>Create New User</h4></div>
    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="form-card">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger mb-3"><ul class="mb-0"><?php foreach ((array)session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form action="<?= base_url('admin/users/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="full_name" class="form-control" value="<?= esc(old('full_name')) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Username *</label><input type="text" name="username" class="form-control" value="<?= esc(old('username')) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required></div>
            <div class="col-md-6"><label class="form-label">Mobile *</label><input type="text" name="mobile" class="form-control" value="<?= esc(old('mobile')) ?>" required></div>
            <div class="col-md-6">
                <label class="form-label">Password *</label>
                <div class="input-group">
                    <input type="password" name="password" id="pwd" class="form-control" placeholder="Min. 6 chars" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="var f=document.getElementById('pwd'),i=document.getElementById('pi');if(f.type==='password'){f.type='text';i.classList.replace('fa-eye','fa-eye-slash');}else{f.type='password';i.classList.replace('fa-eye-slash','fa-eye');}"><i class="fas fa-eye" id="pi"></i></button>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Role *</label>
                <select name="role" id="roleSelect" class="form-select" onchange="document.getElementById('docFields').style.display=this.value==='doctor'?'block':'none'" required>
                    <option value="">Select Role</option>
                    <option value="doctor" <?= old('role')==='doctor'?'selected':'' ?>>Doctor</option>
                    <option value="receptionist" <?= old('role')==='receptionist'?'selected':'' ?>>Receptionist</option>
                </select>
            </div>
            <div id="docFields" style="display:none;" class="col-12">
                <hr class="my-2"><h6 class="text-muted mb-3" style="font-size:.8rem;text-transform:uppercase;">Doctor Details (for Letterpad)</h6>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Degree / Qualifications</label><input type="text" name="degree" class="form-control" placeholder="e.g. MBBS, MD" value="<?= esc(old('degree')) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Specialization</label><input type="text" name="specialization" class="form-control" placeholder="e.g. General Physician" value="<?= esc(old('specialization')) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Clinic Name</label><input type="text" name="clinic_name" class="form-control" value="<?= esc(old('clinic_name')) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Clinic Address</label><textarea name="address" class="form-control" rows="2"><?= esc(old('address')) ?></textarea></div>
                </div>
            </div>
            <div class="col-12 pt-2"><hr class="mt-0">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Create User</button>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script>
if(document.getElementById('roleSelect').value==='doctor'){document.getElementById('docFields').style.display='block';}
</script>
<?php $this->endSection(); ?>
