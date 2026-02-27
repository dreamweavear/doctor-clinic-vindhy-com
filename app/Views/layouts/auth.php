<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title ?? 'Clinic OPD System') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{font-family:'Inter',sans-serif}
body{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem}
.auth-card{background:#fff;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,.25);overflow:hidden;width:100%;max-width:440px}
.auth-header{background:linear-gradient(135deg,#1e40af,#2563eb);padding:2.5rem 2rem 2rem;text-align:center}
.auth-header .brand-icon{width:68px;height:68px;background:rgba(255,255,255,.15);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;backdrop-filter:blur(10px)}
.auth-header h4{color:#fff;font-weight:700;margin:0;font-size:1.3rem}
.auth-header p{color:#bfdbfe;font-size:.85rem;margin:.4rem 0 0}
.auth-body{padding:2rem}
.form-label{font-size:.825rem;font-weight:600;color:#374151;margin-bottom:.375rem}
.form-control{border-radius:10px;border:1.5px solid #e5e7eb;padding:.625rem .875rem;font-size:.875rem;transition:border-color .2s,box-shadow .2s}
.form-control:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.btn-login{background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;padding:.75rem;font-weight:600;font-size:.9rem;border-radius:10px;width:100%;transition:transform .15s,box-shadow .15s}
.btn-login:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(37,99,235,.4);color:#fff}
.input-group .input-group-text{background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:10px 0 0 10px;color:#6b7280}
.input-group .form-control{border-radius:0 10px 10px 0;border-left:none}
.input-group:focus-within .input-group-text{border-color:#2563eb}
.input-group:focus-within .form-control{border-color:#2563eb}
.alert{border-radius:10px;font-size:.85rem;border:none}
.alert-danger{background:#fef2f2;color:#991b1b}
.alert-success{background:#f0fdf4;color:#166534}
</style>
</head>
<body>
<?= $this->renderSection('content') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
