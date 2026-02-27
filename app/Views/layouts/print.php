<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title ?? 'Print') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
<style>
*{font-family:'Inter',sans-serif}
body{background:#f1f5f9;padding:2rem}
.print-container{background:#fff;max-width:800px;margin:0 auto;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden}
.no-print{text-align:center;margin-bottom:1.5rem}
.btn{border-radius:8px;font-size:.875rem;font-weight:500}
@media print{body{background:#fff;padding:0}.no-print{display:none!important}.print-container{border:none;border-radius:0;max-width:100%}}
</style>
</head>
<body>
<div class="no-print">
    <button onclick="window.print()" class="btn btn-primary px-4"><i class="fas fa-print me-2"></i> Print</button>
    <a href="javascript:history.back()" class="btn btn-outline-secondary px-4 ms-2"><i class="fas fa-arrow-left me-2"></i> Back</a>
</div>
<div class="print-container">
<?= $this->renderSection('content') ?>
</div>
</body>
</html>
