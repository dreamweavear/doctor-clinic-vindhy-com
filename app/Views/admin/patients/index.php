<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-procedures me-2 text-primary"></i>All Patients</h4>
        <p class="text-muted mb-0" style="font-size:.85rem;">Read-only view across all doctors</p>
    </div>
</div>

<!-- ===== FILTER SECTION ===== -->
<div class="form-card mb-3" style="border-left: 4px solid #4f81bd;">
    <div class="row g-3 align-items-end">

        <!-- Search -->
        <div class="col-md-3">
            <label class="form-label fw-semibold mb-1" style="font-size:.82rem;">
                <i class="fas fa-search me-1 text-secondary"></i>Search
            </label>
            <input type="text" id="searchInput" class="form-control form-control-sm"
                   placeholder="Name, UHID, mobile..." value="<?= esc($search ?? '') ?>">
        </div>

        <!-- Doctor Filter -->
        <div class="col-md-3">
            <label class="form-label fw-semibold mb-1" style="font-size:.82rem;">
                <i class="fas fa-user-md me-1 text-primary"></i>&#2337;&#2377;&#2325;&#2381;&#2335;&#2352; &#2330;&#2369;&#2344;&#2375;&#2306;
            </label>
            <select id="doctorFilter" class="form-select form-select-sm">
                <option value="all">&#128101; &#2360;&#2349;&#2368; &#2337;&#2377;&#2325;&#2381;&#2335;&#2352;&#2381;&#2360;</option>
                <?php foreach ($doctors as $doc): ?>
                    <option value="<?= esc($doc['id']) ?>">Dr. <?= esc($doc['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date Range Filter -->
        <div class="col-md-3">
            <label class="form-label fw-semibold mb-1" style="font-size:.82rem;">
                <i class="fas fa-calendar-alt me-1 text-success"></i>&#2340;&#2366;&#2352;&#2368;&#2326; &#2352;&#2375;&#2306;&#2332;
            </label>
            <select id="dateRangeFilter" class="form-select form-select-sm">
                <option value="all">&#128197; &#2360;&#2349;&#2368; &#2352;&#2367;&#2325;&#2377;&#2352;&#2381;&#2337;</option>
                <option value="today">&#2310;&#2332;</option>
                <option value="yesterday">&#2325;&#2354;</option>
                <option value="this_week">&#2311;&#2360; &#2361;&#2347;&#2381;&#2340;&#2375;</option>
                <option value="last_week">&#2346;&#2367;&#2331;&#2354;&#2366; &#2361;&#2347;&#2381;&#2340;&#2366;</option>
                <option value="this_month">&#2311;&#2360; &#2350;&#2361;&#2368;&#2344;&#2375;</option>
                <option value="last_month">&#2346;&#2367;&#2331;&#2354;&#2366; &#2350;&#2361;&#2368;&#2344;&#2366;</option>
                <option value="custom">&#128198; &#2325;&#2360;&#2381;&#2335;&#2350; &#2352;&#2375;&#2306;&#2332;...</option>
            </select>
        </div>

        <!-- Patient Count Badge + Reset -->
        <div class="col-md-3">
            <label class="form-label fw-semibold mb-1" style="font-size:.82rem; visibility:hidden;">x</label>
            <div class="d-flex gap-2 align-items-center">
                <div class="flex-grow-1 text-center py-1 px-2 rounded text-white fw-bold"
                     style="background:linear-gradient(135deg,#4f81bd,#2e5da1); font-size:.82rem;">
                    <i class="fas fa-users me-1"></i>&#2325;&#2369;&#2354;:
                    <span id="patientCount" style="font-size:1.1rem;"><?= count($patients) ?></span>
                </div>
                <button id="resetFilters" class="btn btn-outline-secondary btn-sm" title="Reset filters">
                    <i class="fas fa-undo"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Custom Date Range (hidden by default) -->
    <div id="customDateRange" class="row g-2 mt-2 d-none">
        <div class="col-md-3">
            <label class="form-label mb-1" style="font-size:.8rem;">&#2330;&#2381;&#2352;&#2379;&#2306; &#2340;&#2366;&#2352;&#2368;&#2326;:</label>
            <input type="date" id="fromDate" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <label class="form-label mb-1" style="font-size:.8rem;">&#2340;&#2325; &#2340;&#2366;&#2352;&#2368;&#2326;:</label>
            <input type="date" id="toDate" class="form-control form-control-sm">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button id="applyCustomRange" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-check me-1"></i>&#2354;&#2366;&#2327;&#2370; &#2325;&#2352;&#2375;&#2306;
            </button>
        </div>
    </div>
</div>

<!-- Patient Table -->
<div class="table-card">
    <div class="table-card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold" style="font-size:.875rem;">
            Patients (<span id="tableCount"><?= count($patients) ?></span>)
        </h6>
        <div id="loadingSpinner" class="d-none">
            <span class="spinner-border spinner-border-sm text-primary me-1"></span>
            <span style="font-size:.8rem; color:#666;">Loading...</span>
        </div>
    </div>

    <div id="patientTableContainer">
        <?php if (empty($patients)): ?>
            <div class="p-4 text-center text-muted">
                <i class="fas fa-procedures fa-2x mb-2 d-block"></i>No patients found.
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr><th>UHID</th><th>Name</th><th>Gender/Age</th><th>Mobile</th><th>Doctor</th><th>Registered</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $p): ?>
                    <tr>
                        <td><span class="uhid-badge"><?= esc($p['uhid']) ?></span></td>
                        <td class="fw-semibold"><?= esc($p['full_name']) ?></td>
                        <td class="text-capitalize"><?= esc($p['gender']) ?><?= $p['age'] ? ', '.$p['age'].' yrs' : '' ?></td>
                        <td><?= esc($p['mobile'] ?? '—') ?></td>
                        <td style="font-size:.8rem;">Dr. <?= esc($p['doctor_name']) ?></td>
                        <td class="text-muted" style="font-size:.8rem;"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
(function () {
    'use strict';
    var filterUrl = '<?= base_url('admin/patients/filter') ?>';
    var debounceTimer = null;
    var doctorFilter    = document.getElementById('doctorFilter');
    var dateRangeFilter = document.getElementById('dateRangeFilter');
    var searchInput     = document.getElementById('searchInput');
    var customDateRange = document.getElementById('customDateRange');
    var fromDate        = document.getElementById('fromDate');
    var toDate          = document.getElementById('toDate');
    var applyBtn        = document.getElementById('applyCustomRange');
    var resetBtn        = document.getElementById('resetFilters');
    var patientCount    = document.getElementById('patientCount');
    var tableCount      = document.getElementById('tableCount');
    var spinner         = document.getElementById('loadingSpinner');
    var tableContainer  = document.getElementById('patientTableContainer');

    dateRangeFilter.addEventListener('change', function () {
        if (this.value === 'custom') {
            customDateRange.classList.remove('d-none');
        } else {
            customDateRange.classList.add('d-none');
            fetchPatients();
        }
    });
    applyBtn.addEventListener('click', fetchPatients);
    doctorFilter.addEventListener('change', fetchPatients);
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchPatients, 400);
    });
    resetBtn.addEventListener('click', function () {
        doctorFilter.value = 'all';
        dateRangeFilter.value = 'all';
        searchInput.value = '';
        fromDate.value = '';
        toDate.value = '';
        customDateRange.classList.add('d-none');
        fetchPatients();
    });

    function fetchPatients() {
        var params = new URLSearchParams({
            doctor_id  : doctorFilter.value,
            date_range : dateRangeFilter.value,
            from_date  : fromDate.value,
            to_date    : toDate.value,
            search     : searchInput.value
        });
        spinner.classList.remove('d-none');
        fetch(filterUrl + '?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            spinner.classList.add('d-none');
            if (d.success) { renderTable(d.patients, d.count); }
        })
        .catch(function() { spinner.classList.add('d-none'); });
    }

    function renderTable(patients, count) {
        patientCount.textContent = count;
        tableCount.textContent   = count;
        if (patients.length === 0) {
            tableContainer.innerHTML = '<div class="p-4 text-center text-muted"><i class="fas fa-search fa-2x mb-2 d-block text-warning"></i><strong>&#2325;&#2379;&#2312; &#2346;&#2375;&#2358;&#2375;&#2306;&#2335; &#2344;&#2361;&#2368;&#2306; &#2350;&#2367;&#2354;&#2366;</strong><br><small>&#2330;&#2369;&#2344;&#2375; &#2327;&#2319; &#2347;&#2367;&#2354;&#2381;&#2335;&#2352; &#2360;&#2375; &#2325;&#2379;&#2312; &#2346;&#2375;&#2358;&#2375;&#2306;&#2335; &#2344;&#2361;&#2368;&#2306; &#2350;&#2367;&#2354;&#2366;&#2404;</small></div>';
            return;
        }
        var rows = '';
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        patients.forEach(function(p) {
            var age = p.age ? ', ' + p.age + ' yrs' : '';
            var mob = p.mobile || '-';
            var d = new Date(p.created_at);
            var reg = ('0'+d.getDate()).slice(-2)+' '+months[d.getMonth()]+' '+d.getFullYear();
            rows += '<tr><td><span class="uhid-badge">'+e(p.uhid)+'</span></td><td class="fw-semibold">'+e(p.full_name)+'</td><td class="text-capitalize">'+e(p.gender)+e(age)+'</td><td>'+e(mob)+'</td><td style="font-size:.8rem;">Dr. '+e(p.doctor_name)+'</td><td class="text-muted" style="font-size:.8rem;">'+reg+'</td></tr>';
        });
        tableContainer.innerHTML = '<div class="table-responsive"><table class="table mb-0"><thead><tr><th>UHID</th><th>Name</th><th>Gender/Age</th><th>Mobile</th><th>Doctor</th><th>Registered</th></tr></thead><tbody>'+rows+'</tbody></table></div>';
    }

    function e(s) {
        if (s == null) return '';
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
    }
})();
</script>

<?php $this->endSection(); ?>