<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-th-large me-2 text-primary"></i>Dashboard</h4>
    <p class="text-muted mb-0">Welcome, <?= esc(session()->get('full_name')) ?>!</p></div>
</div>
<div class="row g-3 mb-4">
    <div class="col-sm-4"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_patients ?></div><div class="stat-label">Patients</div></div>
        <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8;"><i class="fas fa-procedures"></i></div>
    </div></div></div>
    <div class="col-sm-4"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= count($assigned_doctors) ?></div><div class="stat-label">Assigned Doctors</div></div>
        <div class="stat-icon" style="background:#dcfce7;color:#166534;"><i class="fas fa-user-md"></i></div>
    </div></div></div>
    <div class="col-sm-4"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $today_visits ?></div><div class="stat-label">Today Visits</div></div>
        <div class="stat-icon" style="background:#fef3c7;color:#92400e;"><i class="fas fa-calendar-check"></i></div>
    </div></div></div>
</div>
<div class="form-card mb-4">
    <h6 class="mb-3 fw-bold text-secondary" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;">Quick Actions</h6>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= base_url('receptionist/patients/create') ?>" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i>Register Patient</a>
        <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-primary"><i class="fas fa-search me-2"></i>Find Patient</a>
    </div>
</div>
<?php if (!empty($assigned_doctors)): ?>
<div class="table-card"><div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;"><i class="fas fa-user-md me-2 text-primary"></i>My Assigned Doctors</h6></div>
    <div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>Doctor</th><th>Specialization</th><th>Mobile</th></tr></thead>
        <tbody><?php foreach ($assigned_doctors as $d): ?><tr>
            <td><div class="d-flex align-items-center gap-2"><div class="avatar" style="background:#dbeafe;color:#1d4ed8;"><?= strtoupper(substr($d['full_name'],0,1)) ?></div><div class="fw-semibold">Dr. <?= esc($d['full_name']) ?></div></div></td>
            <td><?= esc($d['specialization']??'—') ?></td>
            <td><?= esc($d['mobile']??'—') ?></td>
        </tr><?php endforeach; ?></tbody>
    </table></div>
</div>
<?php else: ?><div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>You are not assigned to any doctor yet. Please contact the administrator.</div><?php endif; ?>
<?php $this->endSection(); ?>
