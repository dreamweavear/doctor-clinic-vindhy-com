<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title ?? 'Clinic OPD System') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
<style>
:root{--sidebar-width:260px;--primary:#2563eb;--sidebar-bg:#0f172a;--sidebar-hover:#1e293b;--topbar-height:64px}
*{font-family:'Inter',sans-serif}
body{background:#f1f5f9;min-height:100vh}
#sidebar{width:var(--sidebar-width);min-height:100vh;background:var(--sidebar-bg);position:fixed;top:0;left:0;bottom:0;z-index:1000;transition:transform .3s;overflow-y:auto}
.sidebar-brand{padding:1.25rem 1.5rem;border-bottom:1px solid #1e293b;background:linear-gradient(135deg,#1e40af,#1d4ed8)}
.sidebar-brand h6{color:#fff;font-weight:700;margin:0}
.sidebar-brand small{color:#93c5fd;font-size:.7rem}
.sidebar-section{padding:.5rem 1rem .25rem;color:#64748b;font-size:.65rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-top:.5rem}
.sidebar-nav a{display:flex;align-items:center;gap:.75rem;padding:.65rem 1.5rem;color:#94a3b8;text-decoration:none;font-size:.875rem;font-weight:500;transition:all .2s;border-left:3px solid transparent}
.sidebar-nav a:hover{background:var(--sidebar-hover);color:#e2e8f0;border-left-color:#334155}
.sidebar-nav a.active{background:rgba(37,99,235,.15);color:#60a5fa;border-left-color:var(--primary)}
.sidebar-nav a i{width:18px;text-align:center;font-size:.875rem}
#topbar{height:var(--topbar-height);background:#fff;border-bottom:1px solid #e2e8f0;position:fixed;top:0;right:0;left:var(--sidebar-width);z-index:999;display:flex;align-items:center;padding:0 1.5rem;gap:1rem;box-shadow:0 1px 3px rgba(0,0,0,.05);transition:left .3s}
.topbar-title{font-weight:600;color:#1e293b;font-size:1rem;flex:1}
.badge-role{font-size:.7rem;padding:.3rem .7rem;border-radius:20px;font-weight:600}
.role-admin{background:#fee2e2;color:#991b1b}
.role-doctor{background:#d1fae5;color:#065f46}
.role-receptionist{background:#e0e7ff;color:#3730a3}
#main-content{margin-left:var(--sidebar-width);padding-top:var(--topbar-height);min-height:100vh;transition:margin-left .3s}
.content-wrapper{padding:1.75rem}
.stat-card{background:#fff;border-radius:12px;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(0,0,0,.04);transition:box-shadow .2s,transform .2s}
.stat-card:hover{box-shadow:0 4px 12px rgba(0,0,0,.08);transform:translateY(-2px)}
.stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem}
.stat-value{font-size:2rem;font-weight:700;color:#0f172a;line-height:1;margin-top:.25rem}
.stat-label{font-size:.8rem;color:#64748b;margin-top:.25rem;font-weight:500}
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-header h4{font-weight:700;color:#0f172a;margin:0}
.table-card{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.table-card-header{padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
.table thead th{background:#f8fafc;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:#64748b;border-bottom:2px solid #e2e8f0;padding:.875rem 1rem}
.table tbody td{padding:.875rem 1rem;font-size:.875rem;vertical-align:middle;color:#374151;border-bottom:1px solid #f1f5f9}
.table tbody tr:last-child td{border-bottom:none}
.table tbody tr:hover td{background:#f8fafc}
.badge-active{background:#d1fae5;color:#065f46;font-size:.7rem}
.badge-inactive{background:#fee2e2;color:#991b1b;font-size:.7rem}
.form-card{background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:1.75rem;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.form-label{font-size:.825rem;font-weight:600;color:#374151;margin-bottom:.375rem}
.form-control,.form-select{font-size:.875rem;border-radius:8px;border:1.5px solid #e2e8f0;padding:.5rem .875rem;transition:border-color .2s,box-shadow .2s}
.form-control:focus,.form-select:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);outline:none}
.btn{border-radius:8px;font-weight:500;font-size:.875rem;padding:.5rem 1rem}
.btn-primary{background:#2563eb;border-color:#2563eb}
.btn-primary:hover{background:#1d4ed8;border-color:#1d4ed8}
.alert{border-radius:10px;font-size:.875rem;border:none}
.alert-success{background:#d1fae5;color:#065f46}
.alert-danger{background:#fee2e2;color:#991b1b}
.alert-warning{background:#fef3c7;color:#92400e}
.alert-info{background:#e0f2fe;color:#0c4a6e}
#sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:998}
@media(max-width:991.98px){#sidebar{transform:translateX(-100%)}#sidebar.show{transform:translateX(0)}#sidebar-overlay.show{display:block}#topbar{left:0}#main-content{margin-left:0}}
.uhid-badge{font-family:monospace;background:#f1f5f9;color:#0f172a;padding:.2rem .5rem;border-radius:6px;font-size:.8rem;font-weight:600}
.avatar{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.875rem;flex-shrink:0}
</style>
</head>
<body>
<div id="sidebar-overlay" onclick="closeSidebar()"></div>
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div style="width:36px;height:36px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-hospital-alt text-white"></i>
            </div>
            <div><h6>Clinic OPD</h6><small>Management System</small></div>
        </div>
    </div>
    <?php $role = session()->get('role') ?>
    <?php if ($role === 'admin'): ?>
        <div class="sidebar-section">Overview</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= ($page??'')==='admin_dashboard'?'active':'' ?>"><i class="fas fa-chart-pie"></i> Dashboard</a>
        </div>
        <div class="sidebar-section">Management</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('admin/users') ?>" class="<?= ($page??'')==='admin_users'?'active':'' ?>"><i class="fas fa-users"></i> Users</a>
            <a href="<?= base_url('admin/mapping') ?>" class="<?= ($page??'')==='admin_mapping'?'active':'' ?>"><i class="fas fa-link"></i> Dr-Rec Mapping</a>
            <a href="<?= base_url('admin/patients') ?>" class="<?= ($page??'')==='admin_patients'?'active':'' ?>"><i class="fas fa-procedures"></i> All Patients</a>
        </div>
    <?php elseif ($role === 'doctor'): ?>
        <div class="sidebar-section">Overview</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('doctor/dashboard') ?>" class="<?= ($page??'')==='doctor_dashboard'?'active':'' ?>"><i class="fas fa-th-large"></i> Dashboard</a>
        </div>
        <div class="sidebar-section">Patient Care</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('doctor/patients') ?>" class="<?= ($page??'')==='doctor_patients'?'active':'' ?>"><i class="fas fa-user-injured"></i> My Patients</a>
        </div>
    <?php elseif ($role === 'receptionist'): ?>
        <div class="sidebar-section">Overview</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('receptionist/dashboard') ?>" class="<?= ($page??'')==='receptionist_dashboard'?'active':'' ?>"><i class="fas fa-th-large"></i> Dashboard</a>
        </div>
        <div class="sidebar-section">OPD</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('receptionist/patients/create') ?>" class="<?= ($page??'')==='receptionist_patients_create'?'active':'' ?>"><i class="fas fa-user-plus"></i> Register Patient</a>
            <a href="<?= base_url('receptionist/patients') ?>" class="<?= ($page??'')==='receptionist_patients'?'active':'' ?>"><i class="fas fa-users"></i> Patient List</a>
        </div>
    <?php endif; ?>
    <div style="padding:1rem 0;">
        <div class="sidebar-section">Account</div>
        <div class="sidebar-nav">
            <a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>
<div id="topbar">
    <button class="btn btn-sm btn-outline-secondary d-lg-none me-2" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    <div class="topbar-title"><?= esc($title ?? 'Clinic OPD') ?></div>
    <div class="d-flex align-items-center gap-3">
        <div class="text-end d-none d-sm-block">
            <div style="font-size:.8rem;font-weight:600;color:#0f172a;"><?= esc(session()->get('full_name')) ?></div>
            <div style="font-size:.7rem;color:#64748b;"><?= esc(session()->get('email')) ?></div>
        </div>
        <span class="badge-role role-<?= session()->get('role') ?>"><?= ucfirst((string)session()->get('role')) ?></span>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</div>
<div id="main-content">
    <div class="content-wrapper">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger"><ul class="mb-0"><?php foreach ((array)session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar(){document.getElementById('sidebar').classList.toggle('show');document.getElementById('sidebar-overlay').classList.toggle('show')}
function closeSidebar(){document.getElementById('sidebar').classList.remove('show');document.getElementById('sidebar-overlay').classList.remove('show')}
setTimeout(function(){document.querySelectorAll('.alert.alert-dismissible.fade.show').forEach(function(el){var a=bootstrap.Alert.getInstance(el)||new bootstrap.Alert(el);a.close()})},5000)
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
