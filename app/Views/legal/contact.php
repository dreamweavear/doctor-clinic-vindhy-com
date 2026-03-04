<?php $this->extend('layouts/legal'); ?>
<?php $this->section('content'); ?>
<div class="p-4 mb-4 rounded-3" style="background:linear-gradient(135deg,#1e1b4b,#3730a3);color:#fff">
    <h1 class="fw-bold mb-1" style="font-size:1.5rem"><i class="fas fa-envelope me-2"></i>&#2360;&#2306;&#2346;&#2352;&#2381;&#2325; &#2325;&#2352;&#2375;&#2306;</h1>
    <div style="color:#a5b4fc;font-weight:600">Contact Us &mdash; clinic.vindhy.com</div>
</div>
<?php if ($sent): ?>
<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><strong>&#2360;&#2306;&#2342;&#2375;&#2358; &#2349;&#2375;&#2332;&#2366; &#2327;&#2351;&#2366;!</strong> &#2343;&#2344;&#2381;&#2351;&#2357;&#2366;&#2342;! &#2361;&#2350; 2 &#2325;&#2366;&#2352;&#2381;&#2351; &#2342;&#2367;&#2357;&#2360;&#2379;&#2306; &#2350;&#2375;&#2306; &#2313;&#2340;&#2381;&#2340;&#2352; &#2342;&#2375;&#2306;&#2327;&#2375;&#2404;<br><small class="text-muted">Thank you! We will respond within 2 business days.</small></div>
<?php endif; ?>
<div class="legal-card">
  <?php if (!empty($errors)): ?>
  <div class="alert alert-danger py-2 mb-3"><ul class="mb-0" style="font-size:.83rem"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
  <?php endif; ?>
  <form action="<?= base_url('contact') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label" style="font-size:.82rem;font-weight:600">&#2344;&#2366;&#2350; / Name *</label>
        <input type="text" name="name" class="form-control" required placeholder="&#2310;&#2346;&#2325;&#2366; &#2344;&#2366;&#2350;" value="<?= esc(old('name')) ?>"></div>
      <div class="col-md-6"><label class="form-label" style="font-size:.82rem;font-weight:600">&#2311;&#2350;&#2375;&#2354; / Email *</label>
        <input type="email" name="email" class="form-control" required placeholder="your@email.com" value="<?= esc(old('email')) ?>"></div>
      <div class="col-md-6"><label class="form-label" style="font-size:.82rem;font-weight:600">&#2350;&#2379;&#2348;&#2366;&#2312;&#2354; / Mobile</label>
        <input type="text" name="mobile" class="form-control" placeholder="10-digit" value="<?= esc(old('mobile')) ?>"></div>
      <div class="col-md-6"><label class="form-label" style="font-size:.82rem;font-weight:600">&#2357;&#2367;&#2359;&#2351; / Subject</label>
        <select name="subject" class="form-select">
          <option value="general">&#2360;&#2366;&#2350;&#2366;&#2344;&#2381;&#2351; &#2346;&#2370;&#2331;&#2340;&#2366;&#2331; / General Inquiry</option>
          <option value="privacy">&#127376; &#2337;&#2375;&#2335;&#2366; &#2360;&#2369;&#2352;&#2325;&#2381;&#2359;&#2366; &#2358;&#2367;&#2325;&#2366;&#2351;&#2340; / Privacy Complaint</option>
          <option value="consent">&#128221; &#2360;&#2361;&#2350;&#2340;&#2367; &#2357;&#2366;&#2346;&#2360; &#2354;&#2375;&#2344;&#2366; / Withdraw Consent</option>
          <option value="data_delete">&#128465; &#2337;&#2375;&#2335;&#2366; &#2361;&#2335;&#2366;&#2344;&#2375; &#2325;&#2366; &#2309;&#2344;&#2369;&#2352;&#2379;&#2343; / Request Data Deletion</option>
          <option value="technical">&#128295; &#2340;&#2325;&#2344;&#2368;&#2325;&#2368; &#2360;&#2350;&#2360;&#2381;&#2351;&#2366; / Technical Issue</option>
        </select>
      </div>
      <div class="col-12"><label class="form-label" style="font-size:.82rem;font-weight:600">&#2360;&#2306;&#2342;&#2375;&#2358; / Message *</label>
        <textarea name="message" class="form-control" rows="5" required placeholder="&#2309;&#2346;&#2344;&#2366; &#2360;&#2306;&#2342;&#2375;&#2358; &#2351;&#2361;&#2366;&#2305; &#2354;&#2367;&#2326;&#2375;&#2306;..."><?= esc(old('message')) ?></textarea></div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-paper-plane me-2"></i>&#2360;&#2306;&#2342;&#2375;&#2358; &#2349;&#2375;&#2332;&#2375;&#2306; / Send Message</button>
      </div>
    </div>
  </form>
</div>
<div class="legal-card">
  <h2 class="section-title mb-3"><i class="fas fa-map-marker-alt"></i>&#2360;&#2368;&#2343;&#2366; &#2360;&#2306;&#2346;&#2352;&#2381;&#2325; / Direct Contact</h2>
  <ul style="font-size:.87rem">
    <li><i class="fas fa-envelope me-1 text-primary"></i> <a href="mailto:info@clinic.vindhy.com">info@clinic.vindhy.com</a></li>
    <li><i class="fas fa-clock me-1 text-success"></i> &#2360;&#2379;&#2350;&#2357;&#2366;&#2352;&ndash;&#2358;&#2344;&#2367;&#2357;&#2366;&#2352;, 9 AM &ndash; 6 PM</li>
  </ul>
</div>
<?php $this->endSection(); ?>
