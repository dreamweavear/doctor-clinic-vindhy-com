<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<style>
.med-row{background:#f8fafc;border:1px solid #e2e8f0!important;border-radius:10px!important;padding:1rem!important;margin-bottom:.75rem!important;position:relative;}
.meal-toggles{display:flex;gap:6px;flex-wrap:wrap;align-items:center;}
.meal-btn{display:flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;border:1.5px solid #cbd5e1;background:#fff;cursor:pointer;font-size:.78rem;font-weight:600;color:#64748b;transition:all .18s;user-select:none;}
.meal-btn:hover{border-color:#3b82f6;color:#3b82f6;}
.meal-btn.morning.active{background:#fef3c7;border-color:#f59e0b;color:#92400e;}
.meal-btn.noon.active{background:#dcfce7;border-color:#22c55e;color:#166534;}
.meal-btn.evening.active{background:#ede9fe;border-color:#7c3aed;color:#5b21b6;}
.freq-display{font-size:.72rem;color:#64748b;margin-top:4px;min-height:16px;}
.freq-display span{background:#f1f5f9;padding:2px 8px;border-radius:10px;font-weight:600;}
.or-sep{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;}
/* History panel */
.hist-panel{background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:1rem;}
.hist-panel .hist-title{font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#92400e;margin-bottom:.75rem;display:flex;align-items:center;gap:6px;}
.hist-visit{background:#fff;border:1px solid #fde68a;border-radius:8px;padding:.75rem;margin-bottom:.5rem;}
.hist-visit:last-child{margin-bottom:0;}
.hist-date{font-size:.8rem;font-weight:700;color:#0f172a;}
.hist-complaint{font-size:.75rem;color:#64748b;margin-top:1px;}
.hist-meds{margin-top:.5rem;display:flex;flex-wrap:wrap;gap:4px;}
.hist-med-chip{background:#fef9c3;border:1px solid #fde047;border-radius:12px;padding:2px 10px;font-size:.72rem;color:#713f12;font-weight:500;}
.hist-more{font-size:.72rem;color:#94a3b8;}
.history-expand{font-size:.75rem;color:#3b82f6;cursor:pointer;border:none;background:none;padding:0;margin-top:.35rem;text-decoration:underline;}
</style>
<div class="page-header">
    <div><h4><i class="fas fa-prescription-bottle me-2 text-primary"></i>Create Prescription</h4>
    <p class="text-muted mb-0">Patient: <strong><?= esc($visit['patient_name']) ?></strong> | <span class="uhid-badge"><?= esc($visit['uhid']) ?></span> | Token: <span class="badge bg-primary"><?= esc($visit['token_number']) ?></span></p></div>
    <a href="<?= base_url("doctor/patients/view/{$visit['patient_id']}") ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>

<?php if (!empty($previous_history)): ?>
<!-- ─── Previous Visit History ─── -->
<div class="hist-panel mb-3">
    <div class="hist-title">
        <i class="fas fa-history"></i> Previous Visit History
        <span class="badge bg-warning text-dark ms-auto"><?= count($previous_history) ?> visit(s)</span>
    </div>
    <?php foreach ($previous_history as $hi => $h): ?>
    <div class="hist-visit">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="hist-date"><i class="far fa-calendar-alt me-1 text-warning"></i><?= date('d M Y', strtotime($h['visit_date'])) ?></div>
                <?php if ($h['chief_complaint'] ?? ''): ?><div class="hist-complaint">Complaint: <?= esc($h['chief_complaint']) ?></div><?php endif; ?>
            </div>
            <?php if ($h['followup_date'] ?? ''): ?>
            <div style="font-size:.72rem;color:#6b7280;">Follow-up: <?= date('d M Y', strtotime($h['followup_date'])) ?></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($h['medicines'])): ?>
        <div class="hist-meds">
            <?php $shown = array_slice($h['medicines'], 0, 3); $extra = count($h['medicines']) - 3; ?>
            <?php foreach ($shown as $m): ?>
            <span class="hist-med-chip"><?= esc($m['medicine_name']) ?><?= $m['dosage'] ? ' '.$m['dosage'] : '' ?> — <?= esc($m['frequency'] ?: '—') ?></span>
            <?php endforeach; ?>
            <?php if ($extra > 0): ?>
            <span class="hist-more">+<?= $extra ?> more</span>
            <?php endif; ?>
        </div>
        <!-- Full details collapse -->
        <?php if (count($h['medicines']) > 3): ?>
        <button class="history-expand" type="button" data-bs-toggle="collapse" data-bs-target="#hist<?= $hi ?>">Show all medicines</button>
        <div class="collapse mt-2" id="hist<?= $hi ?>">
            <table class="table table-sm table-bordered" style="font-size:.78rem;">
                <thead class="table-warning"><tr><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th></tr></thead>
                <tbody>
                <?php foreach ($h['medicines'] as $m): ?>
                <tr><td><?= esc($m['medicine_name']) ?></td><td><?= esc($m['dosage'] ?? '—') ?></td><td><?= esc($m['frequency'] ?? '—') ?></td><td><?= esc($m['duration'] ?? '—') ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <?php if ($h['notes'] ?? ''): ?><div style="font-size:.72rem;color:#6b7280;margin-top:.35rem;border-top:1px dashed #fde68a;padding-top:.35rem;">Notes: <?= esc($h['notes']) ?></div><?php endif; ?>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<form action="<?= base_url('doctor/prescriptions/store') ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="visit_id" value="<?= esc($visit['id']) ?>">
    <div class="row g-3">
        <div class="col-md-4"><div class="form-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-info"></i>Visit Info</h6>
            <table class="table table-sm table-borderless mb-3" style="font-size:.85rem;">
                <tr><th style="color:#64748b;">Patient</th><td><?= esc($visit['patient_name']) ?></td></tr>
                <tr><th style="color:#64748b;">Age/Gender</th><td><?= esc($visit['gender']??'') ?><?= $visit['age']?', '.$visit['age'].' yrs':'' ?></td></tr>
                <tr><th style="color:#64748b;">Date</th><td><?= date('d M Y', strtotime($visit['visit_date'])) ?></td></tr>
                <?php if ($visit['chief_complaint']): ?><tr><th style="color:#64748b;">Complaint</th><td><?= esc($visit['chief_complaint']) ?></td></tr><?php endif; ?>
            </table>
            <hr>
            <div class="mb-3"><label class="form-label">Diagnosis</label><textarea name="diagnosis_note" class="form-control" rows="2" placeholder="Diagnosis..."></textarea></div>
            <div class="mb-3"><label class="form-label">Advice / Notes</label><textarea name="notes" class="form-control" rows="3" placeholder="Diet, rest, special instructions..."></textarea></div>
            <div class="mb-3"><label class="form-label">Follow-up Date</label><input type="date" name="followup_date" class="form-control" min="<?= date('Y-m-d', strtotime('+1 day')) ?>"></div>
        </div></div>
        <div class="col-md-8"><div class="form-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-pills me-2 text-success"></i>Medicines</h6>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="addMed()"><i class="fas fa-plus me-1"></i>Add Medicine</button>
            </div>
            <div id="medRows">
                <div class="med-row" data-idx="0">
                    <button type="button" class="btn btn-sm btn-outline-danger" style="position:absolute;top:8px;right:8px;padding:2px 8px;font-size:.75rem;display:none;" onclick="this.closest('.med-row').remove()"><i class="fas fa-times"></i></button>
                    <div class="row g-2">
                        <div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Medicine Name *</label>
                        <input type="text" name="medicines[0][medicine_name]" class="form-control form-control-sm" placeholder="e.g. Paracetamol 500mg" required></div>
                        <div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Dosage</label>
                        <input type="text" name="medicines[0][dosage]" class="form-control form-control-sm" placeholder="500mg / 5ml"></div>
                        <div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Duration</label>
                        <input type="text" name="medicines[0][duration]" class="form-control form-control-sm" placeholder="5 days / 1 week"></div>
                        <div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Instructions</label>
                        <select name="medicines[0][instructions]" class="form-select form-select-sm">
                            <option value="">— Timing —</option>
                            <option>Before food</option><option>After food</option><option>With food</option>
                            <option>Empty stomach</option><option>At bedtime</option>
                        </select></div>
                        <div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Frequency</label>
                        <div class="meal-toggles" id="mne-0">
                            <button type="button" class="meal-btn morning" data-slot="M" onclick="toggleMeal(this,0)"><i class="fas fa-sun" style="color:#f59e0b"></i> Morning</button>
                            <button type="button" class="meal-btn noon"    data-slot="N" onclick="toggleMeal(this,0)"><i class="fas fa-cloud-sun" style="color:#22c55e"></i> Noon</button>
                            <button type="button" class="meal-btn evening" data-slot="E" onclick="toggleMeal(this,0)"><i class="fas fa-moon" style="color:#7c3aed"></i> Evening</button>
                            <span class="or-sep">or</span>
                            <select class="form-select form-select-sm" style="width:auto;max-width:150px;" onchange="selectPreset(this,0)">
                                <option value="">Custom...</option>
                                <option>SOS</option><option>Once weekly</option><option>Twice weekly</option>
                                <option>Once monthly</option><option>Stat (immediately)</option>
                            </select>
                        </div>
                        <div class="freq-display" id="fdisplay-0"><span style="color:#cbd5e1;">Select above</span></div>
                        <input type="hidden" name="medicines[0][frequency]" id="fval-0" value=""></div>
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Save &amp; Print</button>
            </div>
        </div></div>
    </div>
</form>
<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script>
var rc = 1;
var FREQ_MAP = {
    'M':'Morning only (1-0-0)','N':'Noon only (0-1-0)','E':'Evening only (0-0-1)',
    'MN':'Morning + Noon (1-1-0)','ME':'Morning + Evening (1-0-1)',
    'NE':'Noon + Evening (0-1-1)','MNE':'Morning + Noon + Evening (1-1-1)'
};
function toggleMeal(btn,idx){
    document.querySelector('#mne-'+idx+' select').value='';
    btn.classList.toggle('active');
    updateFreq(idx);
}
function selectPreset(sel,idx){
    document.querySelectorAll('#mne-'+idx+' .meal-btn').forEach(b=>b.classList.remove('active'));
    updateFreq(idx);
}
function updateFreq(idx){
    var active=[];
    document.querySelectorAll('#mne-'+idx+' .meal-btn.active').forEach(b=>active.push(b.dataset.slot));
    var preset=document.querySelector('#mne-'+idx+' select').value;
    var freq=active.length>0?(FREQ_MAP[active.join('')]||active.join('+')):preset;
    document.getElementById('fval-'+idx).value=freq;
    document.getElementById('fdisplay-'+idx).innerHTML=freq?'<span>'+freq+'</span>':'<span style="color:#cbd5e1;">Select above</span>';
}
function medRowHTML(i){
return `<div class="med-row" data-idx="${i}">
<button type="button" class="btn btn-sm btn-outline-danger" style="position:absolute;top:8px;right:8px;padding:2px 8px;font-size:.75rem;" onclick="this.closest('.med-row').remove()"><i class="fas fa-times"></i></button>
<div class="row g-2">
<div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Medicine Name *</label>
<input type="text" name="medicines[${i}][medicine_name]" class="form-control form-control-sm" placeholder="e.g. Amoxicillin 250mg" required></div>
<div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Dosage</label>
<input type="text" name="medicines[${i}][dosage]" class="form-control form-control-sm" placeholder="500mg / 5ml"></div>
<div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Duration</label>
<input type="text" name="medicines[${i}][duration]" class="form-control form-control-sm" placeholder="5 days / 1 week"></div>
<div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Instructions</label>
<select name="medicines[${i}][instructions]" class="form-select form-select-sm">
<option value="">— Timing —</option><option>Before food</option><option>After food</option><option>With food</option><option>Empty stomach</option><option>At bedtime</option>
</select></div>
<div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Frequency</label>
<div class="meal-toggles" id="mne-${i}">
<button type="button" class="meal-btn morning" data-slot="M" onclick="toggleMeal(this,${i})"><i class="fas fa-sun" style="color:#f59e0b"></i> Morning</button>
<button type="button" class="meal-btn noon" data-slot="N" onclick="toggleMeal(this,${i})"><i class="fas fa-cloud-sun" style="color:#22c55e"></i> Noon</button>
<button type="button" class="meal-btn evening" data-slot="E" onclick="toggleMeal(this,${i})"><i class="fas fa-moon" style="color:#7c3aed"></i> Evening</button>
<span class="or-sep">or</span>
<select class="form-select form-select-sm" style="width:auto;max-width:150px;" onchange="selectPreset(this,${i})">
<option value="">Custom...</option><option>SOS</option><option>Once weekly</option><option>Twice weekly</option><option>Once monthly</option><option>Stat (immediately)</option>
</select></div>
<div class="freq-display" id="fdisplay-${i}"><span style="color:#cbd5e1;">Select above</span></div>
<input type="hidden" name="medicines[${i}][frequency]" id="fval-${i}" value=""></div>
</div></div>`;
}
function addMed(){document.getElementById('medRows').insertAdjacentHTML('beforeend',medRowHTML(rc++));}
</script>
<?php $this->endSection(); ?>