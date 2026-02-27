<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-user me-2 text-primary"></i><?= esc($patient['full_name']) ?></h4>
    <p class="text-muted mb-0"><span class="uhid-badge"><?= esc($patient['uhid']) ?></span> | Dr. <?= esc($patient['doctor_name']) ?></p></div>
    <div class="d-flex gap-2">
        <a href="<?= base_url("receptionist/visits/create/{$patient['id']}") ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>New Visit</a>
        <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>
</div>
<div class="row g-3">
    <div class="col-md-4"><div class="form-card h-100"><h6 class="fw-bold mb-3 text-primary"><i class="fas fa-id-card me-2"></i>Patient Details</h6>
        <table class="table table-sm table-borderless" style="font-size:.875rem;">
            <tr><th style="color:#64748b;">Gender</th><td class="text-capitalize"><?= esc($patient['gender']) ?></td></tr>
            <tr><th style="color:#64748b;">Age</th><td><?= esc($patient['age']??'—') ?> yrs</td></tr>
            <tr><th style="color:#64748b;">Mobile</th><td><?= esc($patient['mobile']??'—') ?></td></tr>
            <tr><th style="color:#64748b;">Blood Group</th><td><?= esc($patient['blood_group']??'—') ?></td></tr>
            <tr><th style="color:#64748b;">Address</th><td><?= esc($patient['address']??'—') ?></td></tr>
            <?php if ($patient['allergies']): ?><tr><th style="color:#ef4444;">Allergies</th><td style="color:#ef4444;font-weight:600;"><?= esc($patient['allergies']) ?></td></tr><?php endif; ?>
        </table>
    </div></div>
    <div class="col-md-8"><div class="table-card h-100">
        <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;"><i class="fas fa-history me-2 text-primary"></i>Visit History (<?= count($visits) ?>)</h6></div>
        <?php if (empty($visits)): ?><div class="p-4 text-center text-muted"><i class="fas fa-calendar fa-2x mb-2 d-block"></i>No visits yet. <a href="<?= base_url("receptionist/visits/create/{$patient['id']}") ?>">Create first visit</a></div>
        <?php else: ?>
        <div style="max-height:400px;overflow-y:auto;">
        <?php foreach ($visits as $v): ?>
        <div class="p-3 border-bottom"><div class="d-flex align-items-start justify-content-between">
            <div>
                <div class="d-flex gap-2 mb-1"><span class="badge bg-primary">Token: <?= esc($v['token_number']) ?></span><span class="text-muted" style="font-size:.8rem;"><?= date('d M Y', strtotime($v['visit_date'])) ?></span></div>
                <?php if ($v['chief_complaint']): ?><div style="font-size:.85rem;"><?= esc(mb_strimwidth($v['chief_complaint'],0,80,'…')) ?></div><?php endif; ?>
            </div>
            <a href="<?= base_url("receptionist/visits/slip/{$v['id']}") ?>" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="fas fa-print me-1"></i>Slip</a>
        </div></div>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div></div>
</div>
<?php $this->endSection(); ?>
