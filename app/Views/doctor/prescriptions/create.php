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
/* VOICE */
.voice-panel{background:linear-gradient(135deg,#eff6ff,#f0fdf4);border:1.5px solid #bfdbfe;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem;}
.vp-title{font-size:.78rem;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.6rem;display:flex;align-items:center;gap:6px;}
#btnVoiceFull{border-radius:25px;font-size:.85rem;font-weight:600;padding:7px 18px;transition:all .2s;}
#btnVoiceFull.listening{background:#dc2626!important;border-color:#dc2626!important;color:#fff!important;animation:pulse-mic 1.2s infinite;}
@keyframes pulse-mic{0%{box-shadow:0 0 0 0 rgba(220,38,38,.4);}70%{box-shadow:0 0 0 10px rgba(220,38,38,0);}100%{box-shadow:0 0 0 0 rgba(220,38,38,0);}}
#voiceStatus{font-size:.72rem;font-weight:600;border-radius:20px;padding:3px 10px;}
#liveTranscript{background:#fff;border:1px dashed #93c5fd;border-radius:8px;padding:.5rem .75rem;margin-top:.5rem;font-size:.82rem;color:#1e40af;min-height:32px;}
.btn-voice-single{border-color:#93c5fd;color:#3b82f6;background:#eff6ff;padding:0 8px;border-radius:0 6px 6px 0!important;}
.btn-voice-single:hover{background:#3b82f6;color:#fff;border-color:#3b82f6;}
.btn-voice-single.listening{background:#dc2626!important;border-color:#dc2626!important;color:#fff!important;animation:pulse-mic 1s infinite;}
</style>

<div class="page-header">
    <div><h4><i class="fas fa-prescription-bottle me-2 text-primary"></i>Create Prescription</h4>
    <p class="text-muted mb-0">Patient: <strong><?= esc($visit['patient_name']) ?></strong> | <span class="uhid-badge"><?= esc($visit['uhid']) ?></span> | Token: <span class="badge bg-primary"><?= esc($visit['token_number']) ?></span></p></div>
    <a href="<?= base_url("doctor/patients/view/{$visit['patient_id']}") ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>

<?php if (!empty($previous_history)): ?>
<div class="hist-panel mb-3">
    <div class="hist-title"><i class="fas fa-history"></i> Previous Visit History<span class="badge bg-warning text-dark ms-auto"><?= count($previous_history) ?> visit(s)</span></div>
    <?php foreach ($previous_history as $hi => $h): ?>
    <div class="hist-visit">
        <div class="d-flex justify-content-between align-items-start">
            <div><div class="hist-date"><i class="far fa-calendar-alt me-1 text-warning"></i><?= date('d M Y', strtotime($h['visit_date'])) ?></div>
            <?php if ($h['chief_complaint'] ?? ''): ?><div class="hist-complaint">Complaint: <?= esc($h['chief_complaint']) ?></div><?php endif; ?></div>
            <?php if ($h['followup_date'] ?? ''): ?><div style="font-size:.72rem;color:#6b7280;">Follow-up: <?= date('d M Y', strtotime($h['followup_date'])) ?></div><?php endif; ?>
        </div>
        <?php if (!empty($h['medicines'])): ?>
        <div class="hist-meds">
            <?php $shown = array_slice($h['medicines'], 0, 3); $extra = count($h['medicines']) - 3; ?>
            <?php foreach ($shown as $m): ?><span class="hist-med-chip"><?= esc($m['medicine_name']) ?><?= $m['dosage'] ? ' '.$m['dosage'] : '' ?> — <?= esc($m['frequency'] ?: '—') ?></span><?php endforeach; ?>
            <?php if ($extra > 0): ?><span class="hist-more">+<?= $extra ?> more</span><?php endif; ?>
        </div>
        <?php if (count($h['medicines']) > 3): ?>
        <button class="history-expand" type="button" data-bs-toggle="collapse" data-bs-target="#hist<?= $hi ?>">Show all medicines</button>
        <div class="collapse mt-2" id="hist<?= $hi ?>">
            <table class="table table-sm table-bordered" style="font-size:.78rem;"><thead class="table-warning"><tr><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th></tr></thead><tbody>
            <?php foreach ($h['medicines'] as $m): ?><tr><td><?= esc($m['medicine_name']) ?></td><td><?= esc($m['dosage'] ?? '—') ?></td><td><?= esc($m['frequency'] ?? '—') ?></td><td><?= esc($m['duration'] ?? '—') ?></td></tr><?php endforeach; ?>
            </tbody></table>
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

            <!-- VOICE PANEL -->
            <div class="voice-panel">
                <div class="vp-title">
                    <i class="fas fa-microphone-alt text-primary"></i>
                    Voice Prescription
                    <span class="badge bg-info ms-1" style="font-size:.6rem;">BETA</span>
                    <small class="ms-auto text-primary" style="font-size:.68rem;font-weight:500;text-transform:none;">Chrome/Edge only</small>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <button type="button" id="btnVoiceFull" class="btn btn-outline-primary btn-sm" onclick="VP.toggleFull()">
                        <i class="fas fa-microphone me-1"></i><span id="btnVoiceLabel">&#2346;&#2370;&#2352;&#2366; &#2346;&#2381;&#2352;&#2367;&#2360;&#2381;&#2325;&#2381;&#2352;&#2367;&#2346;&#2381;&#2358;&#2344; &#2348;&#2379;&#2354;&#2375;&#2306;</span>
                    </button>
                    <span id="voiceStatus" class="badge bg-secondary">&#2340;&#2376;&#2351;&#2366;&#2352;</span>
                    <div class="btn-group btn-group-sm ms-1" role="group" id="langToggle" title="बोलने की भाषा चुनें">
                        <button type="button" id="btnLangHI" class="btn btn-sm btn-warning active px-2" onclick="VP.setLang('hi-IN')" style="font-size:.72rem;font-weight:700;">HI</button>
                        <button type="button" id="btnLangEN" class="btn btn-sm btn-outline-secondary px-2" onclick="VP.setLang('en-IN')" style="font-size:.72rem;font-weight:700;">EN</button>
                    </div>
                    <small class="text-muted d-none d-md-inline" style="font-size:.73rem;">Hindi / English / Hinglish</small>
                </div>
                <div id="liveTranscript" class="d-none">
                    <i class="fas fa-circle text-danger me-1" style="font-size:.5rem;animation:pulse-mic .8s infinite;"></i>
                    <span id="transcriptText" class="fst-italic text-primary"></span>
                </div>
                <div id="voiceNoSupport" class="d-none mt-1 p-2 rounded" style="background:#fef2f2;border:1px solid #fca5a5;font-size:.78rem;color:#991b1b;">
                    <i class="fas fa-exclamation-triangle me-1"></i>Browser voice support नहीं है। Chrome या Edge use करें।
                </div>
                <div class="mt-2 p-2 rounded" style="background:#fff7ed;border:1px solid #fed7aa;font-size:.73rem;color:#92400e;">
                    <strong>&#2313;&#2342;&#2366;&#2361;&#2352;&#2339;:</strong>
                    "Tab Paracetamol 500 mg twice daily 5 days after food"<br>
                    &nbsp;&nbsp;या: "टैबलेट पैरासिटामोल 500 एमजी सुबह-शाम 5 दिन खाने के बाद"<br>
                    &#2351;&#2366; &#2361;&#2367;&#2306;&#2342;&#2368; &#2350;&#2375;&#2306;: "&#2335;&#2376;&#2348;&#2354;&#2375;&#2335; &#2346;&#2376;&#2352;&#2366;&#2360;&#2367;&#2335;&#2366;&#2350;&#2379;&#2354; 500 &#2319;&#2350;&#2332;&#2368; &#2360;&#2369;&#2348;&#2361; &#2358;&#2366;&#2350; 5 &#2342;&#2367;&#2344; &#2326;&#2366;&#2344;&#2375; &#2325;&#2375; &#2348;&#2366;&#2342;"
                </div>
            </div>
            <!-- END VOICE PANEL -->

            <div id="medRows">
                <div class="med-row" data-idx="0">
                    <button type="button" class="btn btn-sm btn-outline-danger" style="position:absolute;top:8px;right:8px;padding:2px 8px;font-size:.75rem;display:none;" onclick="this.closest('.med-row').remove()"><i class="fas fa-times"></i></button>
                    <div class="row g-2">
                        <div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Medicine Name *</label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="medicines[0][medicine_name]" class="form-control" placeholder="e.g. Paracetamol 500mg" required>
                            <button type="button" class="btn btn-voice-single" title="&#2348;&#2379;&#2354;&#2325;&#2352; &#2349;&#2352;&#2375;&#2306;" onclick="VP.startSingle(this)"><i class="fas fa-microphone"></i></button>
                        </div></div>
                        <div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Dosage</label>
                        <input type="text" name="medicines[0][dosage]" class="form-control form-control-sm" placeholder="500mg / 5ml"></div>
                        <div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Duration</label>
                        <input type="text" name="medicines[0][duration]" class="form-control form-control-sm" placeholder="5 days / 1 week"></div>
                        <div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Instructions</label>
                        <select name="medicines[0][instructions]" class="form-select form-select-sm">
                            <option value="">— Timing —</option><option>Before food</option><option>After food</option>
                            <option>With food</option><option>Empty stomach</option><option>At bedtime</option>
                        </select></div>
                        <div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Frequency</label>
                        <div class="meal-toggles" id="mne-0">
                            <button type="button" class="meal-btn morning" data-slot="M" onclick="toggleMeal(this,0)"><i class="fas fa-sun" style="color:#f59e0b"></i> Morning</button>
                            <button type="button" class="meal-btn noon"    data-slot="N" onclick="toggleMeal(this,0)"><i class="fas fa-cloud-sun" style="color:#22c55e"></i> Noon</button>
                            <button type="button" class="meal-btn evening" data-slot="E" onclick="toggleMeal(this,0)"><i class="fas fa-moon" style="color:#7c3aed"></i> Evening</button>
                            <span class="or-sep">or</span>
                            <select class="form-select form-select-sm" style="width:auto;max-width:150px;" onchange="selectPreset(this,0)">
                                <option value="">Custom...</option><option>SOS</option><option>Once weekly</option>
                                <option>Twice weekly</option><option>Once monthly</option><option>Stat (immediately)</option>
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

<!-- VOICE CONFIRM MODAL -->
<div class="modal fade" id="voiceConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4);border-bottom:1px solid #bfdbfe;">
                <h5 class="modal-title fw-bold"><i class="fas fa-microphone-alt me-2 text-primary"></i>Voice &#2360;&#2375; &#2350;&#2367;&#2354;&#2368; &#2342;&#2357;&#2366;&#2311;&#2351;&#2366;&#2305; &#8212; &#2332;&#2366;&#2305;&#2330;&#2375;&#2306; &amp; Confirm &#2325;&#2352;&#2375;&#2306;</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 mb-2" style="font-size:.79rem;">
                    <i class="fas fa-pencil-alt me-1"></i>&#2327;&#2354;&#2340; &#2361;&#2379; &#2340;&#2379; &#2344;&#2368;&#2330;&#2375; directly edit &#2325;&#2352;&#2375;&#2306;, &#2347;&#2367;&#2352; "Form &#2350;&#2375;&#2306; &#2349;&#2352;&#2375;&#2306;" &#2342;&#2348;&#2366;&#2319;&#2306;&#2404;
                </div>
                <div id="voiceConfirmBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="VP.retry()"><i class="fas fa-redo me-1"></i>&#2347;&#2367;&#2352; &#2360;&#2375; &#2348;&#2379;&#2354;&#2375;&#2306;</button>
                <button type="button" class="btn btn-success" onclick="VP.applyToForm()"><i class="fas fa-check me-2"></i>Form &#2350;&#2375;&#2306; &#2349;&#2352;&#2375;&#2306;</button>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script>
var rc=1;
var FREQ_MAP={'M':'Morning only (1-0-0)','N':'Noon only (0-1-0)','E':'Evening only (0-0-1)','MN':'Morning + Noon (1-1-0)','ME':'Morning + Evening (1-0-1)','NE':'Noon + Evening (0-1-1)','MNE':'Morning + Noon + Evening (1-1-1)'};
function toggleMeal(btn,idx){document.querySelector('#mne-'+idx+' select').value='';btn.classList.toggle('active');updateFreq(idx);}
function selectPreset(sel,idx){document.querySelectorAll('#mne-'+idx+' .meal-btn').forEach(function(b){b.classList.remove('active');});updateFreq(idx);}
function updateFreq(idx){var active=[];document.querySelectorAll('#mne-'+idx+' .meal-btn.active').forEach(function(b){active.push(b.dataset.slot);});var preset=document.querySelector('#mne-'+idx+' select').value;var freq=active.length>0?(FREQ_MAP[active.join('')]||active.join('+')):preset;document.getElementById('fval-'+idx).value=freq;document.getElementById('fdisplay-'+idx).innerHTML=freq?'<span>'+freq+'</span>':'<span style="color:#cbd5e1;">Select above</span>';}
/* ─── Medicine dictionary: Hindi/phonetic → English ─── */
var medicineMapping = {
    'पैरासिटामोल':'Paracetamol','पेरासिटामोल':'Paracetamol','paracetamol':'Paracetamol',
    'अमोक्सिसिलिन':'Amoxicillin','amoxicillin':'Amoxicillin',
    'एजिथ्रोमाइसिन':'Azithromycin','azithromycin':'Azithromycin',
    'आइबुप्रोफेन':'Ibuprofen','ibuprofen':'Ibuprofen',
    'डाइक्लोफेनेक':'Diclofenac','diclofenac':'Diclofenac',
    'मेटफारमिन':'Metformin','metformin':'Metformin',
    'ओमिप्राज़ोल':'Omeprazole','omeprazole':'Omeprazole',
    'पैन्टोप्राज़ोल':'Pantoprazole','pantoprazole':'Pantoprazole',
    'सेटीरिज़िन':'Cetirizine','cetirizine':'Cetirizine',
    'लेवोसेटिरिज़िन':'Levocetirizine','levocetirizine':'Levocetirizine',
    'अम्लोदिपिन':'Amlodipine','amlodipine':'Amlodipine',
    'रैनिटिडिन':'Ranitidine','ranitidine':'Ranitidine'
};

function medRowHTML(i){
    var instrOpts = '<option value="">— चुनें / Select —</option>'
        +'<optgroup label="हिंदी">'
        +'<option value="खाने के बाद">खाने के बाद</option>'
        +'<option value="खाने से पहले">खाने से पहले</option>'
        +'<option value="खाली पेट">खाली पेट</option>'
        +'<option value="खाने के साथ">खाने के साथ</option>'
        +'</optgroup>'
        +'<optgroup label="English">'
        +'<option value="After food">After food</option>'
        +'<option value="Before food">Before food</option>'
        +'<option value="Empty stomach">Empty stomach</option>'
        +'<option value="With food">With food</option>'
        +'<option value="At bedtime">At bedtime</option>'
        +'</optgroup>';
    var freqPresets = '<option value="">Custom...</option>'
        +'<optgroup label="हिंदी">'
        +'<option value="दिन में एक बार">दिन में एक बार</option>'
        +'<option value="दिन में दो बार">दिन में दो बार</option>'
        +'<option value="दिन में तीन बार">दिन में तीन बार</option>'
        +'</optgroup>'
        +'<optgroup label="English">'
        +'<option value="Once daily">Once daily</option>'
        +'<option value="Twice daily">Twice daily</option>'
        +'<option value="Thrice daily">Thrice daily</option>'
        +'<option value="SOS">SOS</option>'
        +'<option value="Once weekly">Once weekly</option>'
        +'<option value="Twice weekly">Twice weekly</option>'
        +'<option value="Once monthly">Once monthly</option>'
        +'<option value="Stat (immediately)">Stat (immediately)</option>'
        +'</optgroup>';
    return '<div class="med-row" data-idx="'+i+'">'
        +'<button type="button" class="btn btn-sm btn-outline-danger" style="position:absolute;top:8px;right:8px;padding:2px 8px;font-size:.75rem;" onclick="this.closest(\'.med-row\').remove()"><i class="fas fa-times"></i></button>'
        +'<div class="row g-2">'
        +'<div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Medicine Name *</label>'
        +'<div class="input-group input-group-sm"><input type="text" name="medicines['+i+'][medicine_name]" class="form-control" placeholder="e.g. Amoxicillin" required>'
        +'<button type="button" class="btn btn-voice-single" onclick="VP.startSingle(this)" title="Voice"><i class="fas fa-microphone"></i></button></div></div>'
        +'<div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Dosage</label>'
        +'<input type="text" name="medicines['+i+'][dosage]" class="form-control form-control-sm" placeholder="500mg/5ml"></div>'
        +'<div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Duration</label>'
        +'<input type="text" name="medicines['+i+'][duration]" class="form-control form-control-sm" placeholder="5 days"></div>'
        +'<div class="col-md-4"><label class="form-label" style="font-size:.75rem;font-weight:600;">Instructions</label>'
        +'<select name="medicines['+i+'][instructions]" class="form-select form-select-sm">'+instrOpts+'</select></div>'
        +'<div class="col-12"><label class="form-label" style="font-size:.75rem;font-weight:600;">Frequency</label>'
        +'<div class="meal-toggles" id="mne-'+i+'">'
        +'<button type="button" class="meal-btn morning" data-slot="M" onclick="toggleMeal(this,'+i+')"><i class="fas fa-sun" style="color:#f59e0b"></i> Morning</button>'
        +'<button type="button" class="meal-btn noon" data-slot="N" onclick="toggleMeal(this,'+i+')"><i class="fas fa-cloud-sun" style="color:#22c55e"></i> Noon</button>'
        +'<button type="button" class="meal-btn evening" data-slot="E" onclick="toggleMeal(this,'+i+')"><i class="fas fa-moon" style="color:#7c3aed"></i> Evening</button>'
        +'<span class="or-sep">or</span>'
        +'<select class="form-select form-select-sm" style="width:auto;max-width:160px;" onchange="selectPreset(this,'+i+')">'+freqPresets+'</select>'
        +'</div>'
        +'<div class="freq-display" id="fdisplay-'+i+'"><span style="color:#cbd5e1;">Select above</span></div>'
        +'<input type="hidden" name="medicines['+i+'][frequency]" id="fval-'+i+'" value=""></div>'
        +'</div></div>';
}
function addMed(){document.getElementById('medRows').insertAdjacentHTML('beforeend',medRowHTML(rc++));}
/* ════════════════════════════════
   VOICE PRESCRIPTION MODULE (VP)
   Web Speech API — Hindi/English/Hinglish
   ════════════════════════════════ */
var VP = (function(){
    'use strict';
    var SR = window.SpeechRecognition || window.webkitSpeechRecognition;
    var recog = null, listening = false, mode = 'full';
    var sBtn = null, sInp = null;
    var voiceLang = 'hi-IN'; // hi-IN or en-IN
    var parsedList = [];
    var bsModal = null;

    document.addEventListener('DOMContentLoaded', function(){
        if (!SR) {
            document.getElementById('voiceNoSupport').classList.remove('d-none');
            var fb = document.getElementById('btnVoiceFull');
            if (fb) fb.disabled = true;
        }
    });

    function setStatus(txt, cls){
        var el = document.getElementById('voiceStatus');
        if (!el) return;
        el.textContent = txt;
        el.className = 'badge bg-' + cls;
    }

    function initRecog(){
        recog = new SR();
        recog.lang = voiceLang;
        recog.continuous = false;
        recog.interimResults = true;
        recog.maxAlternatives = 3;

        recog.onstart = function(){
            listening = true;
            setStatus('\u0938\u0941\u0928 \u0930\u0939\u093e \u0939\u0948...', 'danger');
            if (mode === 'full'){
                document.getElementById('btnVoiceFull').classList.add('listening');
                document.getElementById('btnVoiceLabel').textContent = '\u0930\u094b\u0915\u0947\u0902 (Stop)';
                document.getElementById('liveTranscript').classList.remove('d-none');
            }
        };

        recog.onresult = function(e){
            var interim='', final='';
            for(var i=e.resultIndex;i<e.results.length;i++){
                if(e.results[i].isFinal) final+=e.results[i][0].transcript;
                else interim+=e.results[i][0].transcript;
            }
            document.getElementById('transcriptText').textContent = final||interim;
            if(final){
                if(mode==='full'){
                    stopAll();
                    setStatus('\u092a\u093e\u0930\u094d\u0938 \u0939\u094b \u0930\u0939\u093e \u0939\u0948...','warning');
                    parsedList = parseFull(final, voiceLang);
                    showModal(parsedList);
                } else {
                    var p1 = parseSingle(final);
                    if(sInp) sInp.value = p1.name||final.trim();
                    var row = sBtn ? sBtn.closest('.med-row') : null;
                    if(row && p1.dosage){
                        var d = row.querySelector('[name*="[dosage]"]');
                        if(d) d.value = p1.dosage;
                    }
                    stopAll();
                    setStatus('\u0924\u0948\u092f\u093e\u0930','secondary');
                }
            }
        };

        recog.onerror = function(e){
            stopAll();
            setStatus(e.error!=='no-speech'?'Error: '+e.error:'\u0924\u0948\u092f\u093e\u0930','secondary');
        };
        recog.onend = function(){ if(listening) stopAll(); };
    }

    function stopAll(){
        listening = false;
        if(recog) try{recog.stop();}catch(x){}
        var fb = document.getElementById('btnVoiceFull');
        if(fb){ fb.classList.remove('listening'); }
        document.getElementById('btnVoiceLabel').textContent = '\u092a\u0942\u0930\u093e \u092a\u094d\u0930\u093f\u0938\u094d\u0915\u094d\u0930\u093f\u092a\u094d\u0936\u0928 \u092c\u094b\u0932\u0947\u0902';
        if(sBtn) sBtn.classList.remove('listening');
        setStatus('\u0924\u0948\u092f\u093e\u0930','secondary');
    }

    function parseFull(text, langHint){
        var segs = text.split(/[,;।]|\bऔर\b|\bor\b|\bthen\b|\baur\b/i)
            .map(function(s){return s.trim();}).filter(function(s){return s.length>2;});
        var meds=[];
        segs.forEach(function(seg){
            if(/^(tab|cap|syr|inj|drop|gel|टैब|कैप|सिरप|इंज|tablet|capsule|syrup|injection)/i.test(seg)||meds.length===0){
                meds.push(seg);
            } else {
                meds[meds.length-1]+=', '+seg;
            }
        });
        return meds.map(function(s){return parseSingle(s,langHint);}).filter(function(m){return m.name;});
    }

    /* ─── Language detection: Devanagari = Hindi ─── */
    function detectLanguage(text){
        return /[ऀ-ॿ]/.test(text) ? 'hi' : 'en';
    }

    function parseSingle(text, langHint){
        var t = text.trim();
        var lang = (langHint && langHint.startsWith("en")) ? "en" : detectLanguage(t);
        var r = {name:'',dosage:'',frequency:'',slots:[],duration:'',instructions:'',raw:t,lang:lang};

        /* Instructions — bilingual */
        var iMap = lang === 'hi' ? [
            [/खाने के बाद|after food|after meal/i,        'खाने के बाद'],
            [/खाने से पहले|before food|before meal/i, 'खाने से पहले'],
            [/खाने के साथ|with food|with meal/i,           'खाने के साथ'],
            [/खाली पेट|empty stomach/i,                             'खाली पेट'],
            [/रात को सोते|at bedtime|bedtime|सोने से पहले/i, 'सोने से पहले'],
        ] : [
            [/खाने के बाद|after food|after meal/i,        'After food'],
            [/खाने से पहले|before food|before meal/i,'Before food'],
            [/खाने के साथ|with food|with meal/i,          'With food'],
            [/खाली पेट|empty stomach/i,                            'Empty stomach'],
            [/रात को सोते|at bedtime|bedtime|सोने से पहले/i, 'At bedtime'],
        ];
        iMap.forEach(function(p){ if(p[0].test(t)){r.instructions=p[1]; t=t.replace(p[0],'').trim();} });

        /* Duration */
        var dm = t.match(/(\d+)\s*(दिन|day|week|हफ्त|सप्ताह|month|महीन)/i);
        if(dm){
            var n=dm[1], u=dm[2].toLowerCase();
            if(/दिन|day/i.test(u))                  r.duration=n+' days';
            else if(/week|हफ्त|सप्ताह/i.test(u)) r.duration=n+' week'+(n>1?'s':'');
            else if(/month|महीन/i.test(u))      r.duration=n+' month'+(n>1?'s':'');
            t = t.replace(dm[0],'').trim();
        }

        /* Frequency toggle-slots */
        var fMap = [
            [/सुबह[-\s]?शाम[-\s]?रात|thrice daily|tds|tid|तीन बार/i, ['M','N','E']],
            [/सुबह[-\s]?शाम|twice daily|bd|दो बार|morning.*evening|1-0-1/i, ['M','E']],
            [/सुबह[-\s]?दोपहर|morning.*noon|1-1-0/i, ['M','N']],
            [/दोपहर[-\s]?शाम|noon.*evening|0-1-1/i,  ['N','E']],
            [/सुबह\b|morning\b|1-0-0/i, ['M']],
            [/दोपहर\b|noon\b|0-1-0/i,   ['N']],
            [/शाम\b|रात\b|evening\b|night\b|0-0-1/i, ['E']],
        ];
        var matched=false;
        for(var fi=0;fi<fMap.length;fi++){
            if(fMap[fi][0].test(t)){
                r.slots=fMap[fi][1];
                t=t.replace(fMap[fi][0],'').trim();
                matched=true; break;
            }
        }
        if(!matched){
            var pMap = lang === 'hi' ? [
                [/एक बार|दिन में एक बार|once daily|od/i,   'दिन में एक बार'],
                [/दो बार|दिन में दो बार|twice daily|bd/i,   'दिन में दो बार'],
                [/तीन बार|दिन में तीन बार|thrice daily|tds/i, 'दिन में तीन बार'],
                [/sos|as needed/i,'SOS'],
                [/once weekly/i,'Once weekly'],
                [/once monthly/i,'Once monthly'],
            ] : [
                [/once daily|od|एक बार/i,'Once daily'],
                [/twice daily|bd|दो बार/i,'Twice daily'],
                [/thrice daily|tds|तीन बार/i,'Thrice daily'],
                [/sos|as needed/i,'SOS'],
                [/once weekly/i,'Once weekly'],
                [/once monthly/i,'Once monthly'],
            ];
            for(var pi=0;pi<pMap.length;pi++){
                if(pMap[pi][0].test(t)){ r.frequency=pMap[pi][1]; t=t.replace(pMap[pi][0],'').trim(); break; }
            }
        }

        /* Dosage */
        var dosM=t.match(/(\d+\.?\d*)\s*(mg|ml|gm|mcg|iu|एमजी|एमएल)/i);
        if(dosM){ r.dosage=dosM[1]+' '+dosM[2].replace(/एमजी/i,'mg').replace(/एमएल/i,'ml'); t=t.replace(dosM[0],'').trim(); }

        /* Strip medicine type prefix */
        t=t.replace(/^(tab\.?|tablet|cap\.?|capsule|syr\.?|syrup|inj\.?|injection|drops?|टैब\.?|टैबलेट|कैप\.?|कैप्सूल|सिरप|इंजेक्शन)\s*/i,'');
        var rawName = t.replace(/\s{2,}/g,' ').trim();
        /* Translate Hindi name to English via dictionary */
        r.name = medicineMapping[rawName.toLowerCase()] || medicineMapping[rawName] || rawName;

        /* Build frequency string from slots — Hindi or English label */
        if(r.slots.length){
            var key=r.slots.join('');
            if(lang === 'hi'){
                var hiFreqMap = {
                    'M':'सुबह','N':'दोपहर','E':'शाम',
                    'MN':'सुबह-दोपहर','ME':'सुबह-शाम',
                    'NE':'दोपहर-शाम','MNE':'सुबह-शाम-रात'
                };
                r.frequency = hiFreqMap[key] || r.slots.join('-');
            } else {
                r.frequency = FREQ_MAP[key] || r.slots.join('+');
            }
        }
        return r;
    }

    function showModal(meds){
        setStatus(meds.length?'\u092a\u093e\u0930\u094d\u0938 \u0939\u0941\u0906 \u2713':'\u0915\u0941\u091b \u0928\u0939\u0940\u0902 \u092e\u093f\u0932\u093e', meds.length?'success':'warning');
        if(!meds.length){
            alert('\u0915\u094b\u0908 \u0926\u0935\u093e\u0908 \u0928\u0939\u0940\u0902 \u092e\u093f\u0932\u0940\u0964 \u0938\u093e\u092b \u092c\u094b\u0932\u0947\u0902 \u2014 \u091c\u0948\u0938\u0947: "Tab Paracetamol 500 mg twice daily 5 days after food"');
            setStatus('\u0924\u0948\u092f\u093e\u0930','secondary'); return;
        }
        var html='<div class="table-responsive"><table class="table table-bordered table-sm mb-0" style="font-size:.82rem;">'
            +'<thead class="table-primary"><tr><th>#</th><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th><th>Instructions</th><th>भाषा</th></tr></thead><tbody>';
        meds.forEach(function(m,i){
            html+='<tr><td>'+(i+1)+'</td>'
                +'<td><input class="form-control form-control-sm" id="vc_n_'+i+'" value="'+eh(m.name)+'"></td>'
                +'<td><input class="form-control form-control-sm" id="vc_d_'+i+'" value="'+eh(m.dosage)+'"></td>'
                +'<td><input class="form-control form-control-sm" id="vc_f_'+i+'" value="'+eh(m.frequency)+'"></td>'
                +'<td><input class="form-control form-control-sm" id="vc_u_'+i+'" value="'+eh(m.duration)+'"></td>'
                +(function(){
                    var iOpts=[
                        {v:'',l:'— चुनें / Select —'},
                        {v:'खाने के बाद',l:'खाने के बाद'},{v:'खाने से पहले',l:'खाने से पहले'},
                        {v:'खाली पेट',l:'खाली पेट'},{v:'खाने के साथ',l:'खाने के साथ'},
                        {v:'सोने से पहले',l:'सोने से पहले'},
                        {v:'After food',l:'After food'},{v:'Before food',l:'Before food'},
                        {v:'Empty stomach',l:'Empty stomach'},{v:'With food',l:'With food'},{v:'At bedtime',l:'At bedtime'}
                    ];
                    return '<select class="form-select form-select-sm" id="vc_i_'+i+'">'
                        +iOpts.map(function(o){
                            return '<option value="'+o.v+'"'+(o.v===m.instructions?' selected':'')+'>'+o.l+'</option>';
                        }).join('')+'</select>';
                })()+
                '</td><td><span class="badge '+(m.lang==="hi"?'bg-warning text-dark':'bg-info text-white')+'">'+(m.lang==="hi"?'HI':'EN')+'</span></td></tr>';
        });
        html+='</tbody></table></div>';
        var body=document.getElementById('voiceConfirmBody');
        body.innerHTML=html;
        body.dataset.count=meds.length;
        if(!bsModal) bsModal=new bootstrap.Modal(document.getElementById('voiceConfirmModal'));
        bsModal.show();
    }

    function applyToForm(){
        var count=parseInt(document.getElementById('voiceConfirmBody').dataset.count||0);
        if(!count) return;
        document.getElementById('medRows').innerHTML='';
        rc=0;
        for(var i=0;i<count;i++){
            var nm=document.getElementById('vc_n_'+i).value.trim();
            var ds=document.getElementById('vc_d_'+i).value.trim();
            var fr=document.getElementById('vc_f_'+i).value.trim();
            var du=document.getElementById('vc_u_'+i).value.trim();
            var ins=document.getElementById('vc_i_'+i).value;
            var idx=rc;
            document.getElementById('medRows').insertAdjacentHTML('beforeend',medRowHTML(idx));
            rc++;
            document.querySelector('[name="medicines['+idx+'][medicine_name]"]').value=nm;
            document.querySelector('[name="medicines['+idx+'][dosage]"]').value=ds;
            document.querySelector('[name="medicines['+idx+'][duration]"]').value=du;
            var iSel=document.querySelector('[name="medicines['+idx+'][instructions]"]');
            if(iSel){ iSel.value = ins; }
            var slots=frToSlots(fr);
            if(slots.length){
                slots.forEach(function(s){
                    var b=document.querySelector('#mne-'+idx+' .meal-btn[data-slot="'+s+'"]');
                    if(b) b.classList.add('active');
                });
                updateFreq(idx);
            } else if(fr){
                var sel=document.querySelector('#mne-'+idx+' select');
                if(sel) sel.value=fr;
                updateFreq(idx);
            }
        }
        if(bsModal) bsModal.hide();
        setStatus('Form \u092d\u0930\u093e \u2713','success');
        setTimeout(function(){setStatus('\u0924\u0948\u092f\u093e\u0930','secondary');},3000);
    }

    function frToSlots(freq){
        for(var k in FREQ_MAP){ if(FREQ_MAP[k]===freq) return k.split(''); }
        var s=[];
        if(/morning|\u0938\u0941\u092c\u0939/i.test(freq)) s.push('M');
        if(/noon|\u0926\u094b\u092a\u0939\u0930/i.test(freq)) s.push('N');
        if(/evening|night|\u0936\u093e\u092e|\u0930\u093e\u0924/i.test(freq)) s.push('E');
        return s;
    }

    function eh(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

    return {
        toggleFull: function(){
            if(!SR) return;
            if(listening){stopAll();return;}
            mode='full';
            document.getElementById('transcriptText').textContent='';
            document.getElementById('liveTranscript').classList.remove('d-none');
            initRecog();
            try{recog.start();}catch(e){stopAll();}
        },
        startSingle: function(btn){
            if(!SR) return;
            if(listening){stopAll();return;}
            mode='single'; sBtn=btn;
            sInp=btn.closest('.input-group').querySelector('input');
            btn.classList.add('listening');
            document.getElementById('liveTranscript').classList.remove('d-none');
            document.getElementById('transcriptText').textContent='';
            setStatus('\u0938\u0941\u0928 \u0930\u0939\u093e \u0939\u0948...','danger');
            initRecog();
            try{recog.start();}catch(e){stopAll();}
        },
        setLang: function(lang){
            voiceLang = lang;
            var iHI = document.getElementById("btnLangHI");
            var iEN = document.getElementById("btnLangEN");
            if(iHI) { iHI.className = "btn btn-sm px-2" + (lang==='hi-IN'?" btn-warning active":" btn-outline-secondary"); }
            if(iEN) { iEN.className = "btn btn-sm px-2" + (lang==='en-IN'?" btn-info active":" btn-outline-secondary"); }
        },
        applyToForm: applyToForm,
        retry: function(){
            if(bsModal) bsModal.hide();
            setTimeout(function(){VP.toggleFull();},300);
        }
    };
})();
</script>
<?php $this->endSection(); ?>
