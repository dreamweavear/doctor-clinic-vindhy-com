<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<?php
$months     = array_column($trend, 'month');
$satData    = array_column($trend, 'satisfied');
$dissatData = array_column($trend, 'dissatisfied');
$monthLabels = array_map(fn($m) => date('M Y', strtotime($m . '-01')), $months);
?>
<style>
.sat-stat{border-radius:12px;padding:1.25rem 1.5rem;color:#fff;display:flex;flex-direction:column;gap:4px;}
.sat-stat .num{font-size:2rem;font-weight:800;line-height:1;}
.sat-stat .lbl{font-size:.78rem;opacity:.85;font-weight:500;}
.milestone-box{background:linear-gradient(135deg,#065f46,#047857);color:#fff;border-radius:12px;padding:1.25rem 1.5rem;font-size:14px;line-height:1.7;}
.filter-btn{padding:5px 16px;border-radius:20px;border:1.5px solid #e2e8f0;background:#fff;font-size:.82rem;font-weight:600;cursor:pointer;color:#64748b;text-decoration:none;display:inline-block;}
.filter-btn.active,.filter-btn:hover{background:#3b82f6;color:#fff;border-color:#3b82f6;}
.badge-sat{background:#dcfce7;color:#166534;border-radius:12px;padding:2px 10px;font-size:.75rem;font-weight:700;}
.badge-dis{background:#fee2e2;color:#991b1b;border-radius:12px;padding:2px 10px;font-size:.75rem;font-weight:700;}
</style>
<div class="page-header">
    <div>
        <h4><i class="fas fa-chart-pie me-2 text-success"></i>My Satisfaction Tracker</h4>
        <p class="text-muted mb-0">Doctor Self-Assessment — How well did I treat my patients?</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('doctor/satisfaction/report?days=7') ?>" class="filter-btn <?= $filter==7?'active':'' ?>">7 Days</a>
        <a href="<?= base_url('doctor/satisfaction/report?days=30') ?>" class="filter-btn <?= $filter==30?'active':'' ?>">30 Days</a>
        <a href="<?= base_url('doctor/satisfaction/report?days=180') ?>" class="filter-btn <?= $filter==180?'active':'' ?>">6 Months</a>
    </div>
</div>

<?php if ($milestone): ?>
<div class="milestone-box mb-4">
    <i class="fas fa-award me-2"></i><?= esc($milestone) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="sat-stat" style="background:linear-gradient(135deg,#3b82f6,#6366f1);">
            <div class="num"><?= $summary['total'] ?></div>
            <div class="lbl"><i class="fas fa-users me-1"></i>Total Visits (<?= $filter ?> days)</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="sat-stat" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
            <div class="num"><?= $summary['satisfied'] ?></div>
            <div class="lbl"><i class="fas fa-smile me-1"></i>Satisfied (<?= $summary['rate'] ?>%)</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="sat-stat" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
            <div class="num"><?= $summary['dissatisfied'] ?></div>
            <div class="lbl"><i class="fas fa-frown me-1"></i>Dissatisfied</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="sat-stat" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="num"><?= $allTime['total'] ?></div>
            <div class="lbl"><i class="fas fa-history me-1"></i>All Time Rated</div>
        </div>
    </div>
</div>

<!-- Progress bar -->
<?php if ($summary['total'] > 0): ?>
<div class="form-card mb-4">
    <div class="d-flex justify-content-between mb-2" style="font-size:.875rem;font-weight:600;">
        <span>Satisfaction Rate: <?= $summary['rate'] ?>%</span>
        <span><?= $summary['satisfied'] ?> / <?= $summary['total'] ?> visits rated</span>
    </div>
    <div class="progress" style="height:20px;border-radius:20px;">
        <div class="progress-bar bg-success fw-bold" style="width:<?= $summary['rate'] ?>%;font-size:.75rem;">
            <?= $summary['rate'] ?>%
        </div>
        <div class="progress-bar bg-danger" style="width:<?= 100-$summary['rate'] ?>%;font-size:.75rem;"></div>
    </div>
</div>
<?php endif; ?>

<!-- Charts -->
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="form-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-chart-bar me-2 text-primary"></i>6-Month Trend</h6>
            <canvas id="trendChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-card text-center">
            <h6 class="fw-bold mb-3"><i class="fas fa-chart-pie me-2 text-success"></i>Ratio (<?= $filter ?> days)</h6>
            <?php if ($summary['total'] > 0): ?>
            <canvas id="pieChart" height="170"></canvas>
            <?php else: ?>
            <p class="text-muted mt-4">No data yet.<br>Rate your visits using the<br>Satisfied/Dissatisfied buttons<br>on the prescription print page.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Records -->
<div class="form-card">
    <h6 class="fw-bold mb-3"><i class="fas fa-list me-2 text-info"></i>Detailed Records</h6>
    <?php if (empty($records)): ?>
    <div class="text-center py-4 text-muted">
        <i class="fas fa-heart fa-2x mb-2 d-block text-danger"></i>
        No records yet. After saving a prescription, click <strong>Satisfied</strong> or <strong>Dissatisfied</strong> to rate the visit.
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light"><tr>
                <th>Date</th><th>Patient</th><th>UHID</th><th>Status</th><th>Reason</th>
            </tr></thead>
            <tbody>
            <?php foreach ($records as $r): ?>
            <tr>
                <td><?= date('d M Y', strtotime($r['visit_date'])) ?></td>
                <td><?= esc($r['patient_name']) ?></td>
                <td><span class="uhid-badge"><?= esc($r['uhid']) ?></span></td>
                <td>
                    <?php if ($r['status'] === 'satisfied'): ?>
                    <span class="badge-sat"><i class="fas fa-smile me-1"></i>Satisfied</span>
                    <?php else: ?>
                    <span class="badge-dis"><i class="fas fa-frown me-1"></i>Dissatisfied</span>
                    <?php endif; ?>
                </td>
                <td style="color:#64748b;"><?= esc($r['reason'] ?? '—') ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
// Bar Chart — 6-month trend
(function(){
    var canvas = document.getElementById('trendChart');
    if (!canvas) return;
    new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($monthLabels) ?>,
            datasets: [
                {label: 'Satisfied',     data: <?= json_encode($satData) ?>,    backgroundColor: 'rgba(34,197,94,.85)',  borderRadius: 6},
                {label: 'Dissatisfied',  data: <?= json_encode($dissatData) ?>, backgroundColor: 'rgba(239,68,68,.75)',  borderRadius: 6}
            ]
        },
        options: {responsive:true, plugins:{legend:{position:'top'}}, scales:{y:{beginAtZero:true, ticks:{stepSize:1}}}}
    });
})();

// Doughnut Chart — ratio
(function(){
    var canvas = document.getElementById('pieChart');
    if (!canvas) return;
    <?php if ($summary['total'] > 0): ?>
    new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Satisfied', 'Dissatisfied'],
            datasets: [{data:[<?= $summary['satisfied'] ?>,<?= $summary['dissatisfied'] ?>], backgroundColor:['#22c55e','#ef4444'], borderWidth:0}]
        },
        options: {responsive:true, cutout:'68%', plugins:{legend:{position:'bottom'}}}
    });
    <?php endif; ?>
})();
</script>
<?php $this->endSection(); ?>