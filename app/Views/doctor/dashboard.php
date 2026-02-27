<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-th-large me-2 text-primary"></i>My Dashboard</h4>
    <p class="text-muted mb-0" style="font-size:.85rem;">Welcome, Dr. <?= esc(session()->get('full_name')) ?> — <?= date('D, d M Y') ?></p></div>
</div>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_patients ?></div><div class="stat-label">My Patients</div></div>
        <div class="stat-icon" style="background:#dbeafe;color:#1d4ed8;"><i class="fas fa-user-injured"></i></div>
    </div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $today_visits ?></div><div class="stat-label">Today Visits</div></div>
        <div class="stat-icon" style="background:#dcfce7;color:#166534;"><i class="fas fa-calendar-check"></i></div>
    </div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $total_visits ?></div><div class="stat-label">Total Visits</div></div>
        <div class="stat-icon" style="background:#fef3c7;color:#92400e;"><i class="fas fa-stethoscope"></i></div>
    </div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex align-items-center justify-content-between">
        <div><div class="stat-value"><?= $pending_followups ?></div><div class="stat-label">Follow-ups</div></div>
        <div class="stat-icon" style="background:#fce7f3;color:#be185d;"><i class="fas fa-redo"></i></div>
    </div></div></div>
</div>
<div class="row g-3">
    <div class="col-lg-7">
        <div class="table-card">
            <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;"><i class="fas fa-list-ol me-2 text-primary"></i>Today Visit Queue</h6></div>
            <?php if (empty($today_visit_list)): ?><div class="p-4 text-center text-muted"><i class="fas fa-calendar fa-2x mb-2 d-block"></i>No visits today.</div>
            <?php else: ?>
            <div class="table-responsive"><table class="table mb-0">
                <thead><tr><th>Token</th><th>Patient</th><th>Age/Gender</th><th>Complaint</th><th>Action</th></tr></thead>
                <tbody><?php foreach ($today_visit_list as $v): ?><tr>
                    <td><span class="badge bg-primary"><?= esc($v['token_number']) ?></span></td>
                    <td><div class="fw-semibold"><?= esc($v['patient_name']) ?></div><div class="text-muted" style="font-size:.72rem;"><span class="uhid-badge"><?= esc($v['uhid']) ?></span></div></td>
                    <td style="font-size:.8rem;"><?= esc($v['gender']??'') ?><?= $v['age']?', '.$v['age'].' yrs':'' ?></td>
                    <td style="font-size:.8rem;"><?= esc(mb_strimwidth($v['chief_complaint']??'—',0,40,'…')) ?></td>
                    <td><a href="<?= base_url("doctor/prescriptions/create/{$v['id']}") ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-prescription me-1"></i>Rx</a></td>
                </tr><?php endforeach; ?></tbody>
            </table></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="table-card">
            <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;"><i class="fas fa-redo me-2 text-warning"></i>Upcoming Follow-ups (7 days)</h6></div>
            <?php if (empty($upcoming_followups)): ?><div class="p-4 text-center text-muted"><i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>All clear!</div>
            <?php else: ?>
            <div class="table-responsive"><table class="table mb-0">
                <thead><tr><th>Patient</th><th>Date</th></tr></thead>
                <tbody><?php foreach ($upcoming_followups as $f): ?><tr>
                    <td><div class="fw-semibold" style="font-size:.85rem;"><?= esc($f['patient_name']) ?></div><div class="text-muted" style="font-size:.72rem;"><?= esc($f['patient_mobile']??'') ?></div></td>
                    <td><span class="badge" style="background:#fef3c7;color:#92400e;font-size:.75rem;"><?= date('d M', strtotime($f['followup_date'])) ?></span></td>
                </tr><?php endforeach; ?></tbody>
            </table></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Satisfaction Tracker Widget -->
<?php
$satLabels   = array_map(fn($m) => date('M Y', strtotime($m['month'] . '-01')), $sat_trend);
$satData     = array_column($sat_trend, 'satisfied');
$dissatData  = array_column($sat_trend, 'dissatisfied');
?>
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold" style="font-size:.875rem;">
                    <i class="fas fa-heart me-2 text-danger"></i>My Satisfaction Tracker (Last 30 Days)
                </h6>
                <a href="<?= base_url('doctor/satisfaction/report') ?>" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-chart-bar me-1"></i>Full Report
                </a>
            </div>
            <div class="p-3">
                <?php if ($sat_summary['total'] === 0): ?>
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-heart fa-2x mb-2 d-block text-danger opacity-25"></i>
                    <div style="font-size:.85rem;">No satisfaction data yet.</div>
                    <div style="font-size:.78rem;">After printing a prescription, click <strong>Satisfied</strong> or <strong>Dissatisfied</strong>.</div>
                </div>
                <?php else: ?>
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-sm-4 text-center">
                        <!-- Doughnut -->
                        <div style="max-width:130px;margin:auto;"><canvas id="dashPie"></canvas></div>
                        <div style="font-size:.75rem;margin-top:6px;">
                            <span style="color:#22c55e;font-weight:700;"><?= $sat_summary['satisfied'] ?> Satisfied</span>
                            &nbsp;/&nbsp;
                            <span style="color:#ef4444;font-weight:700;"><?= $sat_summary['dissatisfied'] ?> Dissatisfied</span>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div style="font-size:2.5rem;font-weight:800;color:<?= $sat_summary['rate'] >= 70 ? '#22c55e' : '#ef4444' ?>;">
                            <?= $sat_summary['rate'] ?>%
                        </div>
                        <div style="font-size:.78rem;color:#64748b;">Satisfaction Rate</div>
                        <div class="progress mt-2" style="height:10px;border-radius:10px;">
                            <div class="progress-bar bg-success" style="width:<?= $sat_summary['rate'] ?>%;"></div>
                            <div class="progress-bar bg-danger"  style="width:<?= 100-$sat_summary['rate'] ?>%;"></div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div style="font-size:1.5rem;font-weight:700;color:#3b82f6;"><?= $sat_summary['total'] ?></div>
                        <div style="font-size:.78rem;color:#64748b;">Visits Rated</div>
                    </div>
                </div>
                <!-- Bar trend chart -->
                <canvas id="dashTrend" height="65"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function(){
    var pie = document.getElementById('dashPie');
    if (pie) {
        new Chart(pie.getContext('2d'), {
            type: 'doughnut',
            data: { labels:['Satisfied','Dissatisfied'], datasets:[{ data:[<?= (int)($sat_summary['satisfied'] ?? 0) ?>,<?= (int)($sat_summary['dissatisfied'] ?? 0) ?>], backgroundColor:['#22c55e','#ef4444'], borderWidth:0 }] },
            options:{ responsive:true, cutout:'72%', plugins:{ legend:{display:false} } }
        });
    }
    var bar = document.getElementById('dashTrend');
    if (bar) {
        new Chart(bar.getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($satLabels ?? []) ?>,
                datasets: [
                    { label:'Satisfied',    data:<?= json_encode($satData ?? []) ?>,    backgroundColor:'rgba(34,197,94,.85)', borderRadius:5 },
                    { label:'Dissatisfied', data:<?= json_encode($dissatData ?? []) ?>, backgroundColor:'rgba(239,68,68,.75)', borderRadius:5 }
                ]
            },
            options:{ responsive:true, plugins:{ legend:{position:'bottom',labels:{boxWidth:12,font:{size:11}}} }, scales:{ y:{beginAtZero:true,ticks:{stepSize:1},grid:{color:'#f1f5f9'}}, x:{grid:{display:false}} } }
        });
    }
})();
</script>
<?php $this->endSection(); ?>