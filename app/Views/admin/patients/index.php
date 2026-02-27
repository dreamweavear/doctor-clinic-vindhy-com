<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header"><div><h4><i class="fas fa-procedures me-2 text-primary"></i>All Patients</h4><p class="text-muted mb-0" style="font-size:.85rem;">Read-only view across all doctors</p></div></div>
<div class="form-card mb-3">
    <form method="GET" class="row g-2">
        <div class="col-sm-8"><input type="text" name="search" class="form-control" placeholder="Name, UHID, mobile..." value="<?= esc($search??'') ?>"></div>
        <div class="col-sm-4"><button class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Search</button></div>
    </form>
</div>
<div class="table-card">
    <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Patients (<?= count($patients) ?>)</h6></div>
    <?php if (empty($patients)): ?><div class="p-4 text-center text-muted"><i class="fas fa-procedures fa-2x mb-2 d-block"></i>No patients found.</div>
    <?php else: ?>
    <div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>UHID</th><th>Name</th><th>Gender/Age</th><th>Mobile</th><th>Doctor</th><th>Registered</th></tr></thead>
        <tbody>
        <?php foreach ($patients as $p): ?>
        <tr>
            <td><span class="uhid-badge"><?= esc($p['uhid']) ?></span></td>
            <td class="fw-semibold"><?= esc($p['full_name']) ?></td>
            <td class="text-capitalize"><?= esc($p['gender']) ?><?= $p['age']?', '.$p['age'].' yrs':'' ?></td>
            <td><?= esc($p['mobile']??'—') ?></td>
            <td style="font-size:.8rem;">Dr. <?= esc($p['doctor_name']) ?></td>
            <td class="text-muted" style="font-size:.8rem;"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
