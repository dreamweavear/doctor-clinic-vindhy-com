<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-user-plus me-2 text-primary"></i>Register New Patient</h4></div>
    <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="form-card">
    <?php if (session()->getFlashdata('errors')): ?><div class="alert alert-danger mb-3"><ul class="mb-0"><?php foreach ((array)session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form action="<?= base_url('receptionist/patients/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Assign to Doctor *</label>
                <select name="doctor_id" class="form-select" required>
                    <option value="">— Select Doctor —</option>
                    <?php foreach ($assigned_doctors as $d): ?><option value="<?= $d['id'] ?>" <?= old('doctor_id')==$d['id']?'selected':'' ?>>Dr. <?= esc($d['full_name']) ?><?= $d['specialization']?' ('.esc($d['specialization']).')':'' ?></option><?php endforeach; ?>
                </select>
                <div class="form-text" style="font-size:.72rem;"><i class="fas fa-info-circle me-1"></i>Only assigned doctors shown.</div>
            </div>
            <div class="col-md-6"><label class="form-label">Patient Full Name *</label><input type="text" name="full_name" class="form-control" value="<?= esc(old('full_name')) ?>" required placeholder="Full name"></div>
            <div class="col-md-4"><label class="form-label">Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="">— Select —</option>
                    <option value="male" <?= old('gender')==='male'?'selected':'' ?>>Male</option>
                    <option value="female" <?= old('gender')==='female'?'selected':'' ?>>Female</option>
                    <option value="other" <?= old('gender')==='other'?'selected':'' ?>>Other</option>
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Age (years)</label><input type="number" name="age" class="form-control" value="<?= esc(old('age')) ?>" placeholder="35" min="0" max="150"></div>
            <div class="col-md-4"><label class="form-label">Date of Birth</label><input type="date" name="dob" class="form-control" value="<?= esc(old('dob')) ?>"></div>
            <div class="col-md-6"><label class="form-label">Mobile Number</label><input type="text" name="mobile" class="form-control" value="<?= esc(old('mobile')) ?>" placeholder="10-digit"></div>
            <div class="col-md-6"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" placeholder="Optional"></div>
            <div class="col-md-4"><label class="form-label">Blood Group</label>
                <select name="blood_group" class="form-select">
                    <option value="">— Unknown —</option>
                    <?php foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg): ?><option value="<?= $bg ?>" <?= old('blood_group')===$bg?'selected':'' ?>><?= $bg ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-8"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2"><?= esc(old('address')) ?></textarea></div>
            <div class="col-12"><label class="form-label">Known Allergies</label><input type="text" name="allergies" class="form-control" value="<?= esc(old('allergies')) ?>" placeholder="e.g. Penicillin (or None)"></div>
            <div class="col-12 pt-2"><hr class="mt-0">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-user-plus me-2"></i>Register Patient</button>
                <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php $this->endSection(); ?>
