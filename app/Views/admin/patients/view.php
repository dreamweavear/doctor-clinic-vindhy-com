<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><?= esc($patient['full_name']) ?></h4><p class="text-muted mb-0"><span class="uhid-badge"><?= esc($patient['uhid']) ?></span></p></div>
    <a href="<?= base_url('admin/patients') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="row g-3">
    <div class="col-md-4"><div class="form-card h-100"><h6 class="fw-bold mb-3 text-primary">Patient Details</h6>
        <table class="table table-sm table-borderless" style="font-size:.875rem;">
            <tr><th style="color:#64748b;">Gender</th><td class="text-capitalize"><?= esc($patient['gender']) ?></td></tr>
            <tr><th style="color:#64748b;">Age</th><td><?= esc($patient['age']??'—') ?></td></tr>
            <tr><th style="color:#64748b;">Mobile</th><td><?= esc($patient['mobile']??'—') ?></td></tr>
            <tr><th style="color:#64748b;">Doctor</th><td>Dr. <?= esc($patient['doctor_name']) ?></td></tr>
        </table>
    </div></div>
    <div class="col-md-8"><div class="table-card">
        <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Visits (<?= count($visits) ?>)</h6></div>
        <?php if (empty($visits)): ?><div class="p-4 text-center text-muted">No visits.</div>
        <?php else: ?>
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>Token</th><th>Date</th><th>Complaint</th></tr></thead>
            <tbody><?php foreach ($visits as $v): ?><tr>
                <td><span class="badge bg-primary"><?= esc($v['token_number']) ?></span></td>
                <td style="font-size:.85rem;"><?= date('d M Y', strtotime($v['visit_date'])) ?></td>
                <td style="font-size:.85rem;"><?= esc($v['chief_complaint']??'—') ?></td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php endif; ?>
    </div></div>
</div>
<?php $this->endSection(); ?>
