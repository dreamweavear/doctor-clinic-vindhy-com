<?php $p = $prescription; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Prescription Rx #<?= esc($p['id']) ?></title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:"Times New Roman",Times,serif;font-size:12pt;color:#111;background:#fff;}
.page{width:210mm;min-height:297mm;margin:0 auto;padding:0;display:flex;flex-direction:column;border:1px solid #bbb;}
.lp-header{padding:14pt 20pt 8pt;border-bottom:3px double #1e40af;display:flex;align-items:flex-start;justify-content:space-between;gap:10pt;}
.lp-clinic-name{font-size:20pt;font-weight:700;color:#1e40af;letter-spacing:.5pt;line-height:1.1;}
.lp-doctor-name{font-size:13pt;font-weight:700;color:#0f172a;margin-top:3pt;}
.lp-qual{font-size:9.5pt;color:#374151;margin-top:2pt;}
.lp-addr{font-size:8.5pt;color:#6b7280;margin-top:2pt;}
.lp-contact{text-align:right;font-size:9pt;color:#374151;line-height:1.7;}
.lp-contact strong{color:#0f172a;}
.patient-strip{background:#f0f4ff;border-bottom:1px solid #bfdbfe;padding:7pt 20pt;display:flex;flex-wrap:wrap;gap:0 24pt;font-size:9.5pt;}
.pi{display:flex;gap:4pt;align-items:baseline;}
.pi-label{color:#6b7280;min-width:58pt;}
.pi-val{font-weight:600;color:#0f172a;}
.rx-body{flex:1;padding:10pt 20pt 0;display:flex;flex-direction:column;gap:10pt;}
.cd-row{display:flex;gap:16pt;}
.cd-block{flex:1;border-left:3pt solid #1e40af;padding-left:8pt;}
.cd-label{font-size:8pt;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.5pt;}
.cd-val{font-size:10.5pt;color:#0f172a;margin-top:1pt;}
.rx-label{display:flex;align-items:center;gap:8pt;font-size:9pt;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.5pt;border-bottom:1px solid #bfdbfe;padding-bottom:4pt;}
.rx-sym{font-size:22pt;font-weight:900;color:#1e40af;line-height:1;font-family:serif;}
.med-table{width:100%;border-collapse:collapse;font-size:10pt;margin-top:6pt;}
.med-table thead tr{background:#1e40af;color:#fff;}
.med-table thead th{padding:5pt 8pt;text-align:left;font-size:8.5pt;font-weight:700;letter-spacing:.3pt;}
.med-table tbody tr:nth-child(even){background:#f8faff;}
.med-table tbody td{padding:5pt 8pt;border-bottom:1px solid #e2e8f0;vertical-align:top;}
.advice-box{border:1px solid #bfdbfe;border-radius:4pt;padding:8pt 12pt;font-size:10pt;line-height:1.6;background:#f8faff;}
.advice-box .sec-title{font-size:8pt;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.5pt;margin-bottom:4pt;}
.followup{display:inline-block;border:1pt solid #1e40af;border-radius:4pt;padding:5pt 14pt;font-size:10pt;color:#1e40af;font-weight:600;}
.lp-footer{padding:10pt 20pt 14pt;margin-top:auto;border-top:2px solid #1e40af;display:flex;align-items:flex-end;justify-content:space-between;}
.footer-left{font-size:8.5pt;color:#64748b;line-height:1.6;}
.sig-area{text-align:center;}
.sig-space{height:36pt;}
.sig-line{border-top:1pt solid #374151;width:120pt;margin:0 auto 4pt;}
.sig-name{font-size:10pt;font-weight:700;color:#0f172a;}
.sig-qual{font-size:8.5pt;color:#374151;}
.toolbar{background:#1e40af;color:#fff;padding:8px 20px;display:flex;align-items:center;justify-content:space-between;font-family:sans-serif;font-size:13px;}
.btn-print{background:#fff;color:#1e40af;border:none;padding:6px 18px;border-radius:4px;font-weight:700;cursor:pointer;font-size:13px;}
.btn-close{background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.4);padding:6px 14px;border-radius:4px;cursor:pointer;font-size:13px;}
/* Satisfaction panel */
.sat-panel{background:#f0fdf4;border-top:1px solid #bbf7d0;padding:10px 20px;display:flex;align-items:center;gap:12px;font-family:sans-serif;flex-wrap:wrap;}
.sat-panel .sat-label{font-size:13px;font-weight:600;color:#166534;}
.btn-sat{background:#22c55e;color:#fff;border:none;padding:8px 20px;border-radius:6px;font-size:13px;font-weight:700;cursor:pointer;}
.btn-sat:hover{background:#16a34a;}
.btn-dissat{background:#ef4444;color:#fff;border:none;padding:8px 20px;border-radius:6px;font-size:13px;font-weight:700;cursor:pointer;}
.btn-dissat:hover{background:#dc2626;}
.reason-panel{background:#fef2f2;border-top:1px solid #fecaca;padding:10px 20px;font-family:sans-serif;display:none;flex-wrap:wrap;gap:8px;align-items:center;}
.reason-panel label{font-size:13px;font-weight:600;color:#991b1b;width:100%;}
.reason-input{flex:1;padding:6px 12px;border:1px solid #fca5a5;border-radius:6px;font-size:13px;min-width:200px;}
.btn-save-reason{background:#ef4444;color:#fff;border:none;padding:6px 16px;border-radius:6px;font-size:13px;font-weight:700;cursor:pointer;}
@media print{
  @page{size:A4;margin:0;}
  body{background:#fff!important;}
  .toolbar,.sat-panel,.reason-panel,.sat-msg-area{display:none!important;}
  .page{width:100%;min-height:100vh;border:none!important;margin:0;}
  .lp-header,.patient-strip,.med-table thead tr,.lp-footer{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
}
</style>
</head>
<body>
<div class="toolbar">
  <span>Prescription — Rx #<?= esc($p['id']) ?></span>
  <div style="display:flex;gap:10px;">
    <button class="btn-print" onclick="window.print()"><i class="fas fa-print me-1"></i> Print</button>
    <button class="btn-close" onclick="window.close()">&#10005; Close</button>
  </div>
</div>

<!-- Satisfaction Tracker (hidden on print) -->
<div class="sat-panel" id="satPanel">
  <span class="sat-label"><i class="fas fa-heart me-1"></i> Is visit se aap kitne santusht hain?</span>
  <button class="btn-sat" onclick="saveSat('satisfied')"><i class="fas fa-smile me-1"></i> Santusht</button>
  <button class="btn-dissat" onclick="showReason()"><i class="fas fa-frown me-1"></i> Asantusht</button>
  <div id="satMsg" class="sat-msg-area" style="display:none;"></div>
</div>
<div class="reason-panel" id="reasonPanel">
  <label><i class="fas fa-comment me-1"></i> Karan batayein (vaikalpit):</label>
  <input type="text" id="reasonTxt" class="reason-input" placeholder="Jaise: dawa nahi mili, samay kam tha...">
  <button class="btn-save-reason" onclick="saveSat('dissatisfied')">Save</button>
</div>

<div class="page">
  <div class="lp-header">
    <div>
      <?php if ($p['clinic_name'] ?? ''): ?><div class="lp-clinic-name"><?= esc($p['clinic_name']) ?></div><?php endif; ?>
      <div class="lp-doctor-name">Dr. <?= esc($p['doctor_name']) ?></div>
      <div class="lp-qual"><?= esc($p['degree'] ?? '') ?><?= ($p['degree'] && $p['specialization']) ? '  |  ' : '' ?><?= esc($p['specialization'] ?? '') ?></div>
      <?php if ($p['doctor_address'] ?? ''): ?><div class="lp-addr"><?= esc($p['doctor_address']) ?></div><?php endif; ?>
    </div>
    <div class="lp-contact">
      <?php if ($p['doctor_mobile'] ?? ''): ?><div><strong>Mob:</strong> <?= esc($p['doctor_mobile']) ?></div><?php endif; ?>
      <?php if ($p['doctor_email'] ?? ''): ?><div><strong>Email:</strong> <?= esc($p['doctor_email']) ?></div><?php endif; ?>
      <div><strong>Date:</strong> <?= date('d M Y', strtotime($p['visit_date'] ?? date('Y-m-d'))) ?></div>
      <div><strong>Rx #:</strong> <?= esc($p['id']) ?></div>
    </div>
  </div>
  <div class="patient-strip">
    <div class="pi"><span class="pi-label">Patient</span><span class="pi-val"><?= esc($p['patient_name']) ?></span></div>
    <div class="pi"><span class="pi-label">UHID</span><span class="pi-val"><?= esc($p['uhid']) ?></span></div>
    <div class="pi"><span class="pi-label">Age / Sex</span><span class="pi-val"><?= esc($p['age'] ?? '—') ?> Yr / <?= ucfirst(esc($p['gender'] ?? '')) ?></span></div>
    <?php if ($p['blood_group'] ?? ''): ?><div class="pi"><span class="pi-label">Blood Gp</span><span class="pi-val" style="color:#dc2626;"><?= esc($p['blood_group']) ?></span></div><?php endif; ?>
    <?php if ($p['patient_mobile'] ?? ''): ?><div class="pi"><span class="pi-label">Mobile</span><span class="pi-val"><?= esc($p['patient_mobile']) ?></span></div><?php endif; ?>
    <div class="pi"><span class="pi-label">Token</span><span class="pi-val"><?= esc($p['token_number'] ?? '—') ?></span></div>
  </div>
  <div class="rx-body">
    <?php if (($p['chief_complaint'] ?? '') || ($p['diagnosis'] ?? '')): ?>
    <div class="cd-row">
      <?php if ($p['chief_complaint'] ?? ''): ?><div class="cd-block"><div class="cd-label">Chief Complaint</div><div class="cd-val"><?= nl2br(esc($p['chief_complaint'])) ?></div></div><?php endif; ?>
      <?php if ($p['diagnosis'] ?? ''): ?><div class="cd-block"><div class="cd-label">Diagnosis</div><div class="cd-val"><?= nl2br(esc($p['diagnosis'])) ?></div></div><?php endif; ?>
    </div>
    <?php endif; ?>
    <div>
      <div class="rx-label"><span class="rx-sym">&#8478;</span><span>Medicines Prescribed</span></div>
      <?php if (!empty($p['medicines'])): ?>
      <table class="med-table">
        <thead><tr><th style="width:22pt;">#</th><th>Medicine Name</th><th style="width:55pt;">Dosage</th><th style="width:72pt;">Frequency</th><th style="width:55pt;">Duration</th><th>Instructions</th></tr></thead>
        <tbody>
        <?php foreach ($p['medicines'] as $i => $med): ?>
        <tr>
          <td style="color:#94a3b8;"><?= $i+1 ?></td>
          <td><?= esc($med['medicine_name']) ?></td>
          <td><?= esc($med['dosage'] ?? '—') ?></td>
          <td><?= esc($med['frequency'] ?? '—') ?></td>
          <td><?= esc($med['duration'] ?? '—') ?></td>
          <td style="color:#374151;"><?= esc($med['instructions'] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?><p style="padding:10pt;color:#94a3b8;font-style:italic;">No medicines added.</p><?php endif; ?>
    </div>
    <?php if (($p['advice'] ?? '') || ($p['notes'] ?? '')): ?>
    <div class="cd-row" style="gap:14pt;">
      <?php if ($p['advice'] ?? ''): ?><div class="advice-box" style="flex:1;"><div class="sec-title">Advice</div><?= nl2br(esc($p['advice'])) ?></div><?php endif; ?>
      <?php if ($p['notes'] ?? ''): ?><div class="advice-box" style="flex:1;"><div class="sec-title">Notes</div><?= nl2br(esc($p['notes'])) ?></div><?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($p['follow_up_date'] ?? ''): ?>
    <div><span class="followup"><i class="fas fa-calendar-alt me-1"></i> Next Appointment: <?= date('d M Y', strtotime($p['follow_up_date'])) ?></span></div>
    <?php endif; ?>
    <?php if (!empty($p['prev_visits'])): ?>
    <div style="margin-top:10pt;padding:8pt 12pt;border-top:1pt dashed #cbd5e1;">
      <div style="font-size:8pt;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5pt;margin-bottom:5pt;">Previous Visit Summary</div>
      <?php foreach($p['prev_visits'] as $pv): ?>
      <div style="margin-bottom:4pt;">
        <span style="font-size:8.5pt;font-weight:600;color:#64748b;"><?= date('d M Y', strtotime($pv['visit_date'])) ?></span>
        <?php if(!empty($pv['medicines'])): $mnames=array_map(fn($m)=>$m['medicine_name'],array_slice($pv['medicines'],0,3)); ?>
        <span style="font-size:8pt;color:#94a3b8;"> &mdash; <?= esc(implode(', ', $mnames)) ?><?= count($pv['medicines'])>3?'...':'' ?></span>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="lp-footer">
    <div class="footer-left">
      <div>Computer-generated prescription — <?= date('d M Y H:i') ?></div>
      <?php if ($p['clinic_name'] ?? ''): ?><div><?= esc($p['clinic_name']) ?></div><?php endif; ?>
    </div>
    <div class="sig-area">
      <div class="sig-space"></div>
      <div class="sig-line"></div>
      <div class="sig-name">Dr. <?= esc($p['doctor_name']) ?></div>
      <div class="sig-qual"><?= esc($p['degree'] ?? '') ?><?= ($p['degree'] && $p['specialization']) ? ', ' : '' ?><?= esc($p['specialization'] ?? '') ?></div>
    </div>
  </div>
</div>

<script>
var SAT_VISIT_ID   = <?= (int)($p['visit_id'] ?? 0) ?>;
var SAT_PATIENT_ID = <?= (int)($p['patient_id'] ?? 0) ?>;
var SAT_VISIT_DATE = '<?= esc($p['visit_date'] ?? date('Y-m-d')) ?>';
var SAT_BASE_URL   = '<?= base_url('doctor/satisfaction/save') ?>';
var SAT_CSRF_NAME  = '<?= csrf_token() ?>';
var SAT_CSRF_VAL   = '<?= csrf_hash() ?>';

function showReason(){document.getElementById('reasonPanel').style.display='flex';}

function saveSat(status){
  var reason = status==='dissatisfied' ? document.getElementById('reasonTxt').value : '';
  var fd = new FormData();
  fd.append(SAT_CSRF_NAME, SAT_CSRF_VAL);
  fd.append('visit_id',   SAT_VISIT_ID);
  fd.append('patient_id', SAT_PATIENT_ID);
  fd.append('visit_date', SAT_VISIT_DATE);
  fd.append('status',     status);
  fd.append('reason',     reason);
  fetch(SAT_BASE_URL,{method:'POST',body:fd})
    .then(r=>r.json())
    .then(()=>{
      document.getElementById('satPanel').style.display='none';
      document.getElementById('reasonPanel').style.display='none';
      var msg=document.getElementById('satMsg');
      msg.style.display='block';
      msg.parentElement.style.display='flex';
      msg.parentElement.style.background=status==='satisfied'? '#f0fdf4' : '#fef2f2';
      msg.parentElement.style.padding='10px 20px';
      msg.innerHTML=status==='satisfied'
        ? '<i class="fas fa-check-circle" style="color:#16a34a"></i> <strong style="color:#166534"> Santushti darj ki gayi. Shukriya!</strong>'
        : '<i class="fas fa-exclamation-circle" style="color:#dc2626"></i> <strong style="color:#991b1b"> Asantushti darj ki gayi.</strong>';
    });
}
window.addEventListener('load',()=>{setTimeout(()=>window.print(),400);});
</script>
</body>
</html>
