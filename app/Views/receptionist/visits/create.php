<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-notes-medical me-2 text-primary"></i>Create Visit</h4>
    <p class="text-muted mb-0">Patient: <strong><?= esc($patient['full_name']) ?></strong> | <span class="uhid-badge"><?= esc($patient['uhid']) ?></span> | Dr. <?= esc($patient['doctor_name']) ?></p></div>
    <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="row g-3">
    <div class="col-md-4"><div class="form-card h-100">
        <h6 class="fw-bold mb-3"><i class="fas fa-id-card me-2 text-info"></i>Patient Info</h6>
        <table class="table table-sm table-borderless mb-0" style="font-size:.85rem;">
            <tr><th style="color:#64748b;">UHID</th><td><span class="uhid-badge"><?= esc($patient['uhid']) ?></span></td></tr>
            <tr><th style="color:#64748b;">Gender</th><td class="text-capitalize"><?= esc($patient['gender']) ?></td></tr>
            <tr><th style="color:#64748b;">Age</th><td><?= esc($patient['age']??'—') ?> yrs</td></tr>
            <tr><th style="color:#64748b;">Mobile</th><td><?= esc($patient['mobile']??'—') ?></td></tr>
            <tr><th style="color:#64748b;">Doctor</th><td>Dr. <?= esc($patient['doctor_name']) ?></td></tr>
            <?php if ($patient['allergies']): ?><tr><th style="color:#ef4444;">Allergies</th><td style="color:#ef4444;font-weight:600;"><?= esc($patient['allergies']) ?></td></tr><?php endif; ?>
        </table>
    </div></div>
    <div class="col-md-8"><div class="form-card">
        <h6 class="fw-bold mb-3"><i class="fas fa-stethoscope me-2 text-primary"></i>Visit Details</h6>
        <form action="<?= base_url('receptionist/visits/store') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="patient_id" value="<?= $patient['id'] ?>">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Visit Date *</label><input type="date" name="visit_date" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
                <div class="col-12"><label class="form-label">Chief Complaint</label><textarea name="chief_complaint" class="form-control" rows="3" placeholder="Patient's main complaint..."></textarea></div>
                <div class="col-12"><hr class="my-1"><h6 class="text-muted" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;">Vitals (Optional)</h6></div>
                <div class="col-md-3"><label class="form-label">BP (mmHg)</label><input type="text" name="bp" class="form-control" placeholder="120/80"></div>
                <div class="col-md-3"><label class="form-label">Weight (kg)</label><input type="number" name="weight" class="form-control" placeholder="65" step="0.1"></div>
                <div class="col-md-3"><label class="form-label">Temperature (°F)</label><input type="number" name="temperature" class="form-control" placeholder="98.6" step="0.1"></div>
                <div class="col-md-3"><label class="form-label">Pulse (bpm)</label><input type="number" name="pulse" class="form-control" placeholder="72"></div>
                <div class="col-12 pt-2"><hr class="mt-0">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Create Visit &amp; Print OPD Slip</button>
                    <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div></div>
</div>
<?php $this->endSection(); ?>
