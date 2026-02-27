<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-prescription-bottle me-2 text-primary"></i>Prescription Details</h4>
    <p class="text-muted mb-0">Patient: <strong><?= esc($prescription['patient_name']) ?></strong> | <?= date('d M Y', strtotime($prescription['visit_date'])) ?></p></div>
    <div class="d-flex gap-2">
        <a href="<?= base_url("doctor/prescriptions/print/{$prescription['id']}") ?>" target="_blank" class="btn btn-outline-secondary"><i class="fas fa-print me-2"></i>Print</a>
        <a href="<?= base_url("doctor/patients/view/{$prescription['patient_id']}") ?>" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Back</a>
    </div>
</div>
<div class="row g-3">
    <div class="col-md-4"><div class="form-card">
        <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-info"></i>Info</h6>
        <table class="table table-sm table-borderless" style="font-size:.875rem;">
            <tr><th style="color:#64748b;">UHID</th><td><span class="uhid-badge"><?= esc($prescription['uhid']) ?></span></td></tr>
            <tr><th style="color:#64748b;">Visit</th><td><?= date('d M Y', strtotime($prescription['visit_date'])) ?></td></tr>
            <?php if ($prescription['chief_complaint']): ?><tr><th style="color:#64748b;">Complaint</th><td><?= esc($prescription['chief_complaint']) ?></td></tr><?php endif; ?>
            <?php if ($prescription['notes']): ?><tr><th style="color:#64748b;">Advice</th><td><?= nl2br(esc($prescription['notes'])) ?></td></tr><?php endif; ?>
            <?php if ($prescription['followup_date']): ?><tr><th style="color:#64748b;">Follow-up</th><td class="fw-semibold text-success"><?= date('d M Y', strtotime($prescription['followup_date'])) ?></td></tr><?php endif; ?>
        </table>
    </div></div>
    <div class="col-md-8"><div class="table-card">
        <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Medicines (<?= count($prescription['medicines']) ?>)</h6></div>
        <div class="table-responsive"><table class="table mb-0">
            <thead><tr><th>#</th><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th><th>Instructions</th></tr></thead>
            <tbody><?php foreach ($prescription['medicines'] as $i => $m): ?><tr>
                <td><?= $i+1 ?>.</td>
                <td class="fw-semibold"><?= esc($m['medicine_name']) ?></td>
                <td><?= esc($m['dosage']??'—') ?></td>
                <td><?= esc($m['frequency']??'—') ?></td>
                <td><?= esc($m['duration']??'—') ?></td>
                <td><?= esc($m['instructions']??'—') ?></td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
    </div></div>
</div>
<?php $this->endSection(); ?>
