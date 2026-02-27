<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-chart-pie me-2 text-primary"></i>Admin Dashboard</h4>
    <p class="text-muted mb-0" style="font-size:.85rem;">Welcome back, <?= esc(session()->get('full_name')) ?>!</p></div>
    <div class="text-muted" style="font-size:.8rem;"><i class="fas fa-calendar me-1"></i><?= date('D, d M Y') ?></div>
</div>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_doctors ?></div><div class="stat-label">Total Doctors</div></div>
        <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8;"><i class="fas fa-user-md"></i></div>
    </div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_receptionists ?></div><div class="stat-label">Receptionists</div></div>
        <div class="stat-icon" style="background:#fce7f3;color:#be185d;"><i class="fas fa-user-tie"></i></div>
    </div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_patients ?></div><div class="stat-label">Total Patients</div></div>
        <div class="stat-icon" style="background:#dcfce7;color:#166534;"><i class="fas fa-procedures"></i></div>
    </div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_visits_today ?></div><div class="stat-label">Today Visits</div></div>
        <div class="stat-icon" style="background:#fef3c7;color:#92400e;"><i class="fas fa-calendar-check"></i></div>
    </div></div></div>
</div>
<div class="form-card mb-4">
    <h6 class="mb-3 fw-bold text-secondary" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;">Quick Actions</h6>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i>Add Doctor / Receptionist</a>
        <a href="<?= base_url('admin/mapping') ?>" class="btn btn-outline-primary"><i class="fas fa-link me-2"></i>Manage Mappings</a>
        <a href="<?= base_url('admin/patients') ?>" class="btn btn-outline-success"><i class="fas fa-procedures me-2"></i>View All Patients</a>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary"><i class="fas fa-users me-2"></i>Manage Users</a>
    </div>
</div>
<?php if (!empty($recent_patients)): ?>
<div class="table-card">
    <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Recent Patients</h6><a href="<?= base_url('admin/patients') ?>" class="btn btn-sm btn-outline-primary">View All</a></div>
    <div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>UHID</th><th>Patient</th><th>Doctor</th><th>Registered</th></tr></thead>
        <tbody>
        <?php foreach ($recent_patients as $p): ?>
        <tr>
            <td><span class="uhid-badge"><?= esc($p['uhid']) ?></span></td>
            <td><div class="fw-semibold"><?= esc($p['full_name']) ?></div></td>
            <td>Dr. <?= esc($p['doctor_name']) ?></td>
            <td class="text-muted" style="font-size:.8rem;"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</div>
<?php endif; ?>
<?php $this->endSection(); ?>
