<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-users me-2 text-primary"></i>Patient List</h4><p class="text-muted mb-0" style="font-size:.85rem;">Patients of your assigned doctors</p></div>
    <a href="<?= base_url('receptionist/patients/create') ?>" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i>Register Patient</a>
</div>
<div class="form-card mb-3">
    <form method="GET" class="row g-2">
        <div class="col-sm-8"><input type="text" name="search" class="form-control" placeholder="Search by name, UHID or mobile..." value="<?= esc($search??'') ?>"></div>
        <div class="col-sm-4"><button class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Search</button></div>
    </form>
</div>
<div class="table-card">
    <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Patients (<?= count($patients) ?>)</h6></div>
    <?php if (empty($patients)): ?><div class="p-4 text-center text-muted"><i class="fas fa-user-injured fa-2x mb-2 d-block"></i>No patients found.</div>
    <?php else: ?>
    <div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>UHID</th><th>Patient</th><th>Gender/Age</th><th>Mobile</th><th>Doctor</th><th>Actions</th></tr></thead>
        <tbody><?php foreach ($patients as $p): ?><tr>
            <td><span class="uhid-badge"><?= esc($p['uhid']) ?></span></td>
            <td class="fw-semibold"><?= esc($p['full_name']) ?></td>
            <td class="text-capitalize"><?= esc($p['gender']) ?><?= $p['age']?', '.$p['age'].' yrs':'' ?></td>
            <td><?= esc($p['mobile']??'—') ?></td>
            <td style="font-size:.8rem;">Dr. <?= esc($p['doctor_name']) ?></td>
            <td><div class="d-flex gap-1">
                <a href="<?= base_url("receptionist/visits/create/{$p['id']}") ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus"></i> Visit</a>
                <a href="<?= base_url("receptionist/patients/view/{$p['id']}") ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
            </div></td>
        </tr><?php endforeach; ?></tbody>
    </table></div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
