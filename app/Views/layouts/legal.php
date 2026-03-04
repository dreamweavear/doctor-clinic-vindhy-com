<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title ?? 'clinic.vindhy.com') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{font-family:'Inter',sans-serif}
body{background:#f8fafc;min-height:100vh;display:flex;flex-direction:column}
.legal-nav{background:#0f172a;padding:.75rem 0}
.legal-nav .navbar-brand{color:#fff !important;font-weight:700;font-size:1.1rem;text-decoration:none}
.legal-nav .navbar-brand small{color:#93c5fd;font-size:.7rem;display:block;font-weight:400}
.legal-nav .nav-link{color:#94a3b8 !important;font-size:.82rem;padding:.3rem .75rem !important}
.legal-nav .nav-link:hover{color:#e2e8f0 !important}
.legal-body{flex:1;padding:2rem 0 3rem}
.legal-card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;padding:2rem;box-shadow:0 2px 8px rgba(0,0,0,.05);margin-bottom:1.5rem}
.section-title{font-size:1rem;font-weight:700;color:#1e40af;margin-top:1.5rem;margin-bottom:.5rem;display:flex;align-items:center;gap:.5rem}
.section-title:first-child{margin-top:0}
.bilingual-label{font-size:.78rem;color:#64748b;font-style:italic;display:block;margin-top:.25rem}
.last-updated{background:#eff6ff;color:#1e40af;border-radius:20px;padding:.2rem .75rem;font-size:.72rem;font-weight:600;display:inline-block;margin-bottom:1rem}
.legal-footer{background:#0f172a;color:#94a3b8;padding:1.25rem 0;margin-top:auto;font-size:.8rem}
.legal-footer a{color:#64748b;text-decoration:none;margin:0 .4rem}
.legal-footer a:hover{color:#e2e8f0}
#cookieConsent{position:fixed;bottom:0;left:0;right:0;z-index:9999;background:rgba(15,23,42,.97);color:#e2e8f0;padding:.85rem 0;border-top:2px solid #2563eb}
</style>
</head>
<body>

<nav class="legal-nav navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="fas fa-hospital-alt me-2"></i>clinic.vindhy.com
            <small>Clinic OPD Management System</small>
        </a>
        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#lnav">
            <i class="fas fa-bars" style="color:#94a3b8"></i>
        </button>
        <div class="collapse navbar-collapse" id="lnav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('privacy-policy') ?>">Privacy</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('terms-conditions') ?>">Terms</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('cookie-policy') ?>">Cookies</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('disclaimer') ?>">Disclaimer</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('contact') ?>">Contact</a></li>
                <li class="nav-item ms-2"><a class="btn btn-sm btn-primary px-3" href="<?= base_url('auth/login') ?>">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="legal-body">
    <div class="container" style="max-width:860px">
        <?= $this->renderSection('content') ?>
    </div>
</main>

<footer class="legal-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-2 mb-md-0">
                <i class="fas fa-hospital-alt me-1"></i> &copy; 2026 clinic.vindhy.com &nbsp;|&nbsp; All rights reserved
            </div>
            <div class="col-md-6 text-md-end">
                <a href="<?= base_url('privacy-policy') ?>">Privacy</a>
                <a href="<?= base_url('terms-conditions') ?>">Terms</a>
                <a href="<?= base_url('cookie-policy') ?>">Cookies</a>
                <a href="<?= base_url('disclaimer') ?>">Disclaimer</a>
                <a href="<?= base_url('contact') ?>">Contact</a>
            </div>
        </div>
    </div>
</footer>

<div id="cookieConsent" style="display:none">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <p class="mb-0" style="font-size:.83rem">
                &#127850; &#2351;&#2361; &#2357;&#2375;&#2348;&#2360;&#2366;&#2907;&#2335; &#2360;&#2375;&#2358;&#2344; &#2325;&#2375; &#2354;&#2367;&#2319; &#2310;&#2357;&#2358;&#2381;&#2351;&#2325; &#2325;&#2369;&#2325;&#2368; &#2313;&#2346;&#2351;&#2379;&#2327; &#2325;&#2352;&#2340;&#2368; &#2361;&#2376;&#2404;
                <a href="<?= base_url('cookie-policy') ?>" class="text-warning ms-1">&#2324;&#2352; &#2332;&#2366;&#2344;&#2375;&#2306;</a>
            </p>
            <div class="d-flex gap-2">
                <button id="acceptCookies" class="btn btn-sm btn-success px-3">&#10003; &#2360;&#2381;&#2357;&#2368;&#2325;&#2366;&#2352; &#2325;&#2352;&#2375;&#2306;</button>
                <button id="rejectCookies" class="btn btn-sm btn-outline-light px-3">&#2309;&#2360;&#2381;&#2357;&#2368;&#2325;&#2366;&#2352;</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    if(!localStorage.getItem('cookieConsent')){document.getElementById('cookieConsent').style.display='block';}
    document.getElementById('acceptCookies').onclick=function(){localStorage.setItem('cookieConsent','accepted');document.getElementById('cookieConsent').style.display='none';};
    document.getElementById('rejectCookies').onclick=function(){localStorage.setItem('cookieConsent','rejected');document.getElementById('cookieConsent').style.display='none';};
})();
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
