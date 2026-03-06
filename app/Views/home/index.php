<?php
// Clinic OPD System - Home Page (standalone, no CI4 layout)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic OPD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{font-family:"Inter",sans-serif;}
        /* NAVBAR */
        .top-nav{background:#fff;box-shadow:0 2px 20px rgba(0,0,0,.08);padding:.9rem 0;position:sticky;top:0;z-index:999;}
        .nav-brand{font-weight:800;font-size:1.15rem;color:#1e40af;text-decoration:none;}
        .btn-nav-login{background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:10px;padding:.5rem 1.5rem;font-weight:600;font-size:.9rem;transition:.2s;text-decoration:none;}
        .btn-nav-login:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.4);color:#fff;}
        /* HERO */
        .hero{background:linear-gradient(135deg,#1e3a8a 0%,#2563eb 55%,#7c3aed 100%);min-height:88vh;display:flex;align-items:center;padding:5rem 0 4rem;overflow:hidden;}
        .hero-badge{background:rgba(255,255,255,.15);color:#bfdbfe;border:1px solid rgba(255,255,255,.2);display:inline-block;padding:.35rem 1rem;border-radius:50px;font-size:.8rem;font-weight:600;margin-bottom:1.25rem;}
        .hero-title{font-size:2.8rem;font-weight:800;color:#fff;line-height:1.15;}
        .hero-title span{background:linear-gradient(90deg,#93c5fd,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        .hero-sub{color:#bfdbfe;font-size:1.05rem;line-height:1.75;margin:1.25rem 0 2rem;}
        .btn-hero{background:#fff;color:#1e40af;font-weight:700;font-size:1rem;padding:.85rem 2.5rem;border-radius:12px;border:none;transition:.2s;text-decoration:none;display:inline-block;}
        .btn-hero:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,0,0,.25);color:#1e40af;}
        .btn-hero-out{color:#fff;font-weight:600;padding:.85rem 2rem;border-radius:12px;border:2px solid rgba(255,255,255,.4);background:transparent;transition:.2s;text-decoration:none;display:inline-block;}
        .btn-hero-out:hover{background:rgba(255,255,255,.12);color:#fff;}
        .hero-box{background:rgba(255,255,255,.1);border-radius:24px;backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.2);padding:2.5rem;text-align:center;}
        .big-icon{font-size:5rem;color:rgba(255,255,255,.85);margin-bottom:1.25rem;display:block;}
        .stat-pill{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);color:#fff;border-radius:50px;padding:.4rem 1rem;font-size:.82rem;font-weight:600;display:inline-block;margin:.25rem;}
        /* FEATURES */
        .features-sec{padding:5rem 0;background:#f8fafc;}
        .sec-title{font-weight:800;font-size:1.9rem;color:#1e293b;}
        .sec-sub{color:#64748b;font-size:.95rem;margin-top:.4rem;}
        .feat-card{background:#fff;border-radius:18px;padding:2rem 1.75rem;border:1px solid #e2e8f0;height:100%;transition:.2s;}
        .feat-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(37,99,235,.1);border-color:#bfdbfe;}
        .f-icon{width:58px;height:58px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.1rem;font-size:1.4rem;}
        .feat-card h5{font-weight:700;color:#1e293b;font-size:1rem;margin-bottom:.5rem;}
        .feat-card p{color:#64748b;font-size:.875rem;margin:0;line-height:1.65;}
        /* ROLES */
        .roles-sec{padding:5rem 0;background:#fff;}
        .role-card{border-radius:18px;padding:2.5rem 2rem;height:100%;color:#fff;position:relative;overflow:hidden;}
        .role-card::after{content:"";position:absolute;bottom:-40px;right:-40px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.08);}
        .ri-icon{font-size:2.5rem;margin-bottom:1.1rem;display:block;}
        .role-card h4{font-weight:700;margin-bottom:.5rem;}
        .role-card p{font-size:.875rem;opacity:.85;margin:0;line-height:1.65;}
        .r-admin{background:linear-gradient(135deg,#1e40af,#3b82f6);}
        .r-doctor{background:linear-gradient(135deg,#065f46,#10b981);}
        .r-recept{background:linear-gradient(135deg,#7c2d12,#f97316);}
        /* CTA */
        .cta-sec{padding:5rem 0;background:linear-gradient(135deg,#1e3a8a,#2563eb);text-align:center;}
        .cta-sec h2{font-size:2rem;font-weight:800;color:#fff;}
        .cta-sec p{color:#bfdbfe;font-size:1rem;margin:1rem 0 2rem;}
        .btn-cta{background:#fff;color:#1e40af;font-weight:700;padding:.9rem 3rem;border-radius:12px;font-size:1rem;border:none;text-decoration:none;display:inline-block;transition:.2s;}
        .btn-cta:hover{transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,0,0,.2);color:#1e40af;}
        /* FOOTER */
        footer{background:#0f172a;color:#94a3b8;padding:1.75rem 0;text-align:center;font-size:.85rem;}
        footer a{color:#60a5fa;text-decoration:none;}
        footer a:hover{text-decoration:underline;}
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="top-nav">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="nav-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
      <i class="fas fa-hospital-alt text-primary"></i> Clinic OPD System
    </a>
    <div class="d-flex align-items-center gap-3">
      <a href="#features" class="text-secondary text-decoration-none d-none d-md-inline" style="font-weight:500;font-size:.9rem;">Features</a>
      <a href="#roles" class="text-secondary text-decoration-none d-none d-md-inline" style="font-weight:500;font-size:.9rem;">Roles</a>
      <a href="<?= base_url('auth/login') ?>" class="btn-nav-login">
        <i class="fas fa-sign-in-alt me-1"></i> Login
      </a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero" id="home">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="hero-badge"><i class="fas fa-circle-check me-1"></i> Smart Healthcare Management</span>
        <h1 class="hero-title">Clinic OPD<br><span>Management System</span></h1>
        <p class="hero-sub">
          &#x090F;&#x0915; &#x0906;&#x0927;&#x0941;&#x0928;&#x093F;&#x0915;, &#x0924;&#x0947;&#x091C;&#x093C; &#x0914;&#x0930; &#x0938;&#x0941;&#x0930;&#x0915;&#x094D;&#x0937;&#x093F;&#x0924; OPD &#x092A;&#x094D;&#x0930;&#x092C;&#x0902;&#x0927;&#x0928; &#x092A;&#x094D;&#x0930;&#x0923;&#x093E;&#x0932;&#x0940; &mdash; Doctor, Receptionist &#x0914;&#x0930; Admin &#x0915;&#x0947; &#x0932;&#x093F;&#x090F;।<br>
          &#x092E;&#x0930;&#x0940;&#x091C;&#x093C;&#x094B;&#x0902; &#x0915;&#x093E; &#x0930;&#x093F;&#x0915;&#x0949;&#x0930;&#x094D;&#x0921;, &#x092A;&#x0930;&#x094D;&#x091A;&#x0947;, &#x0935;&#x093F;&#x091C;&#x093C;&#x093F;&#x091F; &#x0938;&#x094D;&#x0932;&#x093F;&#x092A; &mdash; &#x0938;&#x092C; &#x0915;&#x0941;&#x091B; &#x090F;&#x0915; &#x091C;&#x0917;&#x0939;।
        </p>
        <div class="d-flex flex-wrap gap-3">
          <a href="<?= base_url('auth/login') ?>" class="btn-hero"><i class="fas fa-sign-in-alt me-2"></i>Login &#x0915;&#x0930;&#x0947;&#x0902;</a>
          <a href="#features" class="btn-hero-out"><i class="fas fa-info-circle me-2"></i>&#x0914;&#x0930; &#x091C;&#x093E;&#x0928;&#x0947;&#x0902;</a>
        </div>
      </div>
      <div class="col-lg-5 d-none d-lg-block">
        <div class="hero-box">
          <i class="fas fa-hospital big-icon"></i>
          <div>
            <span class="stat-pill"><i class="fas fa-users me-1"></i>Multi-User</span>
            <span class="stat-pill"><i class="fas fa-file-medical me-1"></i>Prescriptions</span>
            <span class="stat-pill"><i class="fas fa-chart-bar me-1"></i>Reports</span>
            <span class="stat-pill"><i class="fas fa-shield-alt me-1"></i>Secure</span>
            <span class="stat-pill"><i class="fas fa-mobile-alt me-1"></i>Responsive</span>
            <span class="stat-pill"><i class="fas fa-print me-1"></i>Print Ready</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features-sec" id="features">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="sec-title">&#x092E;&#x0941;&#x0916;&#x094D;&#x092F; Features</h2>
      <p class="sec-sub">&#x0939;&#x092E;&#x093E;&#x0930;&#x093E; &#x0938;&#x093F;&#x0938;&#x094D;&#x091F;&#x092E; &#x0915;&#x094D;&#x0932;&#x093F;&#x0928;&#x093F;&#x0915; &#x0915;&#x0947; &#x0939;&#x0930; &#x0915;&#x093E;&#x092E; &#x0915;&#x094B; &#x0906;&#x0938;&#x093E;&#x0928; &#x092C;&#x0928;&#x093E;&#x0924;&#x093E; &#x0939;&#x0948;</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <div class="f-icon" style="background:#eff6ff;"><i class="fas fa-user-injured" style="color:#2563eb;"></i></div>
          <h5>Patient Management</h5>
          <p>&#x092E;&#x0930;&#x0940;&#x091C;&#x093C;&#x094B;&#x0902; &#x0915;&#x0940; &#x092A;&#x0942;&#x0930;&#x0940; &#x091C;&#x093E;&#x0928;&#x0915;&#x093E;&#x0930;&#x0940; &mdash; &#x0928;&#x093E;&#x092E;, &#x0909;&#x092E;&#x094D;&#x0930;, &#x092E;&#x094B;&#x092C;&#x093E;&#x0907;&#x0932;, &#x092A;&#x0924;&#x093E; &mdash; &#x0906;&#x0938;&#x093E;&#x0928;&#x0940; &#x0938;&#x0947; &#x0930;&#x091C;&#x093F;&#x0938;&#x094D;&#x091F;&#x0930; &#x0914;&#x0930; &#x0916;&#x094B;&#x091C;&#x0947;&#x0902;।</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <div class="f-icon" style="background:#f0fdf4;"><i class="fas fa-file-prescription" style="color:#16a34a;"></i></div>
          <h5>Digital Prescription</h5>
          <p>Doctor &#x0926;&#x0935;&#x093E;&#x0907;&#x092F;&#x093E;&#x0901;, &#x0916;&#x0941;&#x0930;&#x093E;&#x0915; &#x0914;&#x0930; &#x0928;&#x093F;&#x0930;&#x094D;&#x0926;&#x0947;&#x0936; &#x0921;&#x093F;&#x091C;&#x093F;&#x091F;&#x0932; &#x092A;&#x0930;&#x094D;&#x091A;&#x0947; &#x092E;&#x0947;&#x0902; &#x0932;&#x093F;&#x0916;&#x0947;&#x0902; &#x0914;&#x0930; &#x092A;&#x094D;&#x0930;&#x093F;&#x0902;&#x091F; &#x0915;&#x0930;&#x0947;&#x0902;।</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <div class="f-icon" style="background:#fff7ed;"><i class="fas fa-calendar-check" style="color:#ea580c;"></i></div>
          <h5>Visit Tracking</h5>
          <p>&#x0939;&#x0930; &#x0935;&#x093F;&#x091C;&#x093C;&#x093F;&#x091F; &#x0915;&#x093E; &#x0930;&#x093F;&#x0915;&#x0949;&#x0930;&#x094D;&#x0921; &#x0930;&#x0916;&#x0947;&#x0902;, OPD Token Slip &#x092A;&#x094D;&#x0930;&#x093F;&#x0902;&#x091F; &#x0915;&#x0930;&#x0947;&#x0902; &mdash; workflow &#x0924;&#x0947;&#x091C;&#x093C; &#x0939;&#x094B;।</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <div class="f-icon" style="background:#fdf4ff;"><i class="fas fa-users-cog" style="color:#9333ea;"></i></div>
          <h5>Role Based Access</h5>
          <p>Admin, Doctor, Receptionist &mdash; &#x0939;&#x0930; user &#x0915;&#x094B; &#x0938;&#x093F;&#x0930;&#x094D;&#x092B; &#x0909;&#x0938;&#x0915;&#x0947; &#x0915;&#x093E;&#x092E; &#x0915;&#x093E; access &#x092E;&#x093F;&#x0932;&#x0924;&#x093E; &#x0939;&#x0948;।</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <div class="f-icon" style="background:#fff1f2;"><i class="fas fa-chart-line" style="color:#e11d48;"></i></div>
          <h5>Reports &amp; Analytics</h5>
          <p>&#x092E;&#x0930;&#x0940;&#x091C;&#x093C;&#x094B;&#x0902; &#x0915;&#x0940; &#x0938;&#x0902;&#x0916;&#x094D;&#x092F;&#x093E;, prescription trends &mdash; Admin &#x0915;&#x094B; &#x092A;&#x0942;&#x0930;&#x0940; &#x0930;&#x093F;&#x092A;&#x094B;&#x0930;&#x094D;&#x091F; &#x090F;&#x0915; &#x0915;&#x094D;&#x0932;&#x093F;&#x0915; &#x092E;&#x0947;&#x0902;।</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <div class="f-icon" style="background:#f0f9ff;"><i class="fas fa-print" style="color:#0284c7;"></i></div>
          <h5>Print Ready</h5>
          <p>Prescription &#x0914;&#x0930; Visit Slip &#x0915;&#x094B; &#x0938;&#x0940;&#x0927;&#x0947; &#x092A;&#x094D;&#x0930;&#x093F;&#x0902;&#x091F; &#x0915;&#x0930;&#x0947;&#x0902; &mdash; letterhead &#x0915;&#x0947; &#x0938;&#x093E;&#x0925;।</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ROLES -->
<section class="roles-sec" id="roles">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="sec-title">User Roles</h2>
      <p class="sec-sub">&#x0924;&#x0940;&#x0928; &#x0905;&#x0932;&#x0917;-&#x0905;&#x0932;&#x0917; &#x092D;&#x0942;&#x092E;&#x093F;&#x0915;&#x093E;&#x090F;&#x0902; &mdash; &#x0939;&#x0930; &#x090F;&#x0915; &#x0915;&#x093E; &#x0905;&#x092A;&#x0928;&#x093E; Dashboard</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="role-card r-admin">
          <i class="fas fa-user-shield ri-icon"></i>
          <h4>Admin</h4>
          <p>Users manage &#x0915;&#x0930;&#x0947;&#x0902;, Doctors &#x0935; Receptionists &#x091C;&#x094B;&#x0921;&#x093C;&#x0947;&#x0902;, reports &#x0926;&#x0947;&#x0916;&#x0947;&#x0902; &#x0914;&#x0930; &#x092A;&#x0942;&#x0930;&#x0947; &#x0938;&#x093F;&#x0938;&#x094D;&#x091F;&#x092E; &#x0915;&#x0940; &#x0928;&#x093F;&#x0917;&#x0930;&#x093E;&#x0928;&#x0940; &#x0915;&#x0930;&#x0947;&#x0902;।</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="role-card r-doctor">
          <i class="fas fa-user-md ri-icon"></i>
          <h4>Doctor</h4>
          <p>&#x0905;&#x092A;&#x0928;&#x0947; &#x092E;&#x0930;&#x0940;&#x091C;&#x093C;&#x094B;&#x0902; &#x0915;&#x0940; list &#x0926;&#x0947;&#x0916;&#x0947;&#x0902;, digital prescription &#x0932;&#x093F;&#x0916;&#x0947;&#x0902; &#x0914;&#x0930; satisfaction tracker &#x0938;&#x0947; progress &#x091C;&#x093E;&#x0928;&#x0947;&#x0902;।</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="role-card r-recept">
          <i class="fas fa-user-nurse ri-icon"></i>
          <h4>Receptionist</h4>
          <p>&#x0928;&#x090F; &#x092E;&#x0930;&#x0940;&#x091C;&#x093C; &#x0930;&#x091C;&#x093F;&#x0938;&#x094D;&#x091F;&#x0930; &#x0915;&#x0930;&#x0947;&#x0902;, visit &#x092C;&#x0928;&#x093E;&#x090F;&#x0902;, token slip &#x092A;&#x094D;&#x0930;&#x093F;&#x0902;&#x091F; &#x0915;&#x0930;&#x0947;&#x0902; &#x0914;&#x0930; OPD counter &#x0938;&#x0901;&#x092D;&#x093E;&#x0932;&#x0947;&#x0902;।</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-sec">
  <div class="container">
    <h2><i class="fas fa-rocket me-2"></i>&#x0905;&#x092D;&#x0940; &#x0936;&#x0941;&#x0930;&#x0942; &#x0915;&#x0930;&#x0947;&#x0902;</h2>
    <p>&#x0905;&#x092A;&#x0928;&#x0947; Clinic &#x0915;&#x0947; OPD &#x0915;&#x094B; Digital &#x092C;&#x0928;&#x093E;&#x090F;&#x0902; &mdash; Login &#x0915;&#x0930;&#x0947;&#x0902; &#x0914;&#x0930; Dashboard explore &#x0915;&#x0930;&#x0947;&#x0902;।</p>
    <a href="<?= base_url('auth/login') ?>" class="btn-cta"><i class="fas fa-sign-in-alt me-2"></i>Login &#x0915;&#x0930;&#x0947;&#x0902;</a>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <p class="mb-1"><i class="fas fa-hospital-alt me-1" style="color:#3b82f6;"></i> <strong style="color:#e2e8f0;">Clinic OPD Management System</strong></p>
    <p class="mb-2 small">
      <a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a> &nbsp;|&nbsp;
      <a href="<?= base_url('terms-conditions') ?>">Terms &amp; Conditions</a> &nbsp;|&nbsp;
      <a href="<?= base_url('contact') ?>">Contact Us</a>
    </p>
    <p class="mb-0">&copy; <?= date('Y') ?> All Rights Reserved.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll("a[href^='#']").forEach(a=>{
  a.addEventListener("click",e=>{
    e.preventDefault();
    const t=document.querySelector(a.getAttribute("href"));
    if(t)t.scrollIntoView({behavior:"smooth"});
  });
});
</script>
</body>
</html>