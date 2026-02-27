<?php $this->extend('layouts/print'); ?>
<?php $this->section('content'); ?>
<?php $v = $visit; ?>
<style>
.slip-header{background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;padding:1.25rem 1.75rem;display:flex;align-items:center;justify-content:space-between}
.slip-header h5{margin:0;font-size:1.1rem;font-weight:700}
.slip-header small{color:#bfdbfe;font-size:.75rem}
.token-badge{background:rgba(255,255,255,.2);border:2px solid rgba(255,255,255,.5);border-radius:12px;padding:.75rem 1.25rem;text-align:center}
.token-badge .tn{font-size:2rem;font-weight:800;letter-spacing:2px;line-height:1}
.token-badge small{font-size:.7rem;color:#bfdbfe;display:block}
.slip-body{padding:1.5rem 1.75rem}
.info-table{width:100%;border-collapse:collapse}
.info-table td{padding:.5rem .75rem;font-size:.875rem;border-bottom:1px solid #f1f5f9}
.info-table td:first-child{font-weight:600;color:#64748b;width:40%}
.slip-footer{background:#f8fafc;border-top:2px dashed #e2e8f0;padding:1rem 1.75rem;display:flex;justify-content:space-between;align-items:flex-end}
@media print{.slip-header{-webkit-print-color-adjust:exact;print-color-adjust:exact}}
</style>
<div class="slip-header">
    <div>
        <h5><?= esc($v['clinic_name']??'Clinic OPD') ?></h5>
        <?php if ($v['doctor_address']??''): ?><small><?= esc($v['doctor_address']) ?></small><br><?php endif; ?>
        <small>Dr. <?= esc($v['doctor_name']) ?><?= ($v['specialization']??'')?(' · '.esc($v['specialization'])):'' ?></small>
    </div>
    <div class="token-badge"><div class="tn"><?= esc($v['token_number']) ?></div><small>OPD TOKEN</small></div>
</div>
<div class="slip-body">
    <div class="row g-3">
        <div class="col-6">
            <h6 class="text-muted mb-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.5px;font-weight:700;">Patient</h6>
            <table class="info-table">
                <tr><td>Name</td><td class="fw-semibold"><?= esc($v['patient_name']) ?></td></tr>
                <tr><td>UHID</td><td><span style="font-family:monospace;background:#f1f5f9;padding:.1rem .4rem;border-radius:4px;font-size:.85rem;"><?= esc($v['uhid']) ?></span></td></tr>
                <tr><td>Age/Gender</td><td><?= esc($v['age']??'—') ?> / <?= ucfirst(esc($v['gender']??'')) ?></td></tr>
                <tr><td>Mobile</td><td><?= esc($v['patient_mobile']??'—') ?></td></tr>
                <?php if ($v['blood_group']??''): ?><tr><td>Blood Group</td><td style="color:#dc2626;font-weight:700;"><?= esc($v['blood_group']) ?></td></tr><?php endif; ?>
            </table>
        </div>
        <div class="col-6">
            <h6 class="text-muted mb-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.5px;font-weight:700;">Visit</h6>
            <table class="info-table">
                <tr><td>Date</td><td class="fw-semibold"><?= date('d M Y', strtotime($v['visit_date'])) ?></td></tr>
                <tr><td>Token</td><td><span class="fw-bold text-primary" style="font-size:1.1rem;"><?= esc($v['token_number']) ?></span></td></tr>
                <tr><td>Doctor</td><td>Dr. <?= esc($v['doctor_name']) ?></td></tr>
                <?php if ($v['specialization']??''): ?><tr><td>Specialty</td><td><?= esc($v['specialization']) ?></td></tr><?php endif; ?>
            </table>
        </div>
    </div>
    <?php if ($v['chief_complaint']??''): ?><div class="mt-3 p-3 rounded-3" style="background:#f0f9ff;border:1px solid #bae6fd;"><div style="font-size:.72rem;font-weight:700;color:#0369a1;text-transform:uppercase;margin-bottom:.25rem;">Chief Complaint</div><div style="font-size:.875rem;color:#0c4a6e;"><?= esc($v['chief_complaint']) ?></div></div><?php endif; ?>
    <?php $hasV=($v['bp']??'')||($v['weight']??'')||($v['temperature']??'')||($v['pulse']??''); ?>
    <?php if ($hasV): ?><div class="mt-3 d-flex flex-wrap gap-3">
        <?php if ($v['bp']??''): ?><div class="text-center p-2 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;min-width:80px;"><div style="font-size:.65rem;color:#166534;font-weight:700;text-transform:uppercase;">BP</div><div style="font-size:.9rem;font-weight:700;"><?= esc($v['bp']) ?></div><div style="font-size:.65rem;color:#94a3b8;">mmHg</div></div><?php endif; ?>
        <?php if ($v['weight']??''): ?><div class="text-center p-2 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;min-width:80px;"><div style="font-size:.65rem;color:#1d4ed8;font-weight:700;text-transform:uppercase;">WEIGHT</div><div style="font-size:.9rem;font-weight:700;"><?= esc($v['weight']) ?></div><div style="font-size:.65rem;color:#94a3b8;">kg</div></div><?php endif; ?>
        <?php if ($v['temperature']??''): ?><div class="text-center p-2 rounded-3" style="background:#fff7ed;border:1px solid #fed7aa;min-width:80px;"><div style="font-size:.65rem;color:#c2410c;font-weight:700;text-transform:uppercase;">TEMP</div><div style="font-size:.9rem;font-weight:700;"><?= esc($v['temperature']) ?></div><div style="font-size:.65rem;color:#94a3b8;">°F</div></div><?php endif; ?>
        <?php if ($v['pulse']??''): ?><div class="text-center p-2 rounded-3" style="background:#fdf2f8;border:1px solid #f5d0fe;min-width:80px;"><div style="font-size:.65rem;color:#9d174d;font-weight:700;text-transform:uppercase;">PULSE</div><div style="font-size:.9rem;font-weight:700;"><?= esc($v['pulse']) ?></div><div style="font-size:.65rem;color:#94a3b8;">bpm</div></div><?php endif; ?>
    </div><?php endif; ?>
</div>
<div class="slip-footer">
    <div><div style="font-family:'Courier New',monospace;font-size:.7rem;color:#94a3b8;letter-spacing:2px;"><?= str_repeat('|',30) ?></div><div style="font-size:.7rem;color:#94a3b8;margin-top:.25rem;">Visit #<?= $v['id'] ?> · <?= date('d M Y H:i') ?></div></div>
    <div class="text-end" style="font-size:.75rem;color:#64748b;"><div class="fw-semibold">Please proceed to</div><div style="font-size:1rem;color:#0f172a;font-weight:700;">Dr. <?= esc($v['doctor_name']) ?></div></div>
</div>
<?php $this->endSection(); ?>
