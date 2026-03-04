<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-user-plus me-2 text-primary"></i>Register New Patient</h4></div>
    <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="form-card">
    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mb-3"><ul class="mb-0"><?php foreach ((array)session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form action="<?= base_url('receptionist/patients/store') ?>" method="POST" id="patientForm">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Assign to Doctor *</label>
                <select name="doctor_id" class="form-select" required>
                    <option value="">&#8212; Select Doctor &#8212;</option>
                    <?php foreach ($assigned_doctors as $d): ?><option value="<?= $d['id'] ?>" <?= old('doctor_id')==$d['id']?'selected':'' ?>>Dr. <?= esc($d['full_name']) ?><?= $d['specialization']?' ('.esc($d['specialization']).')':'' ?></option><?php endforeach; ?>
                </select>
                <div class="form-text" style="font-size:.72rem;"><i class="fas fa-info-circle me-1"></i>Only assigned doctors shown.</div>
            </div>
            <div class="col-md-6"><label class="form-label">Patient Full Name *</label><input type="text" name="full_name" class="form-control" value="<?= esc(old('full_name')) ?>" required placeholder="Full name"></div>
            <div class="col-md-4"><label class="form-label">Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="">&#8212; Select &#8212;</option>
                    <option value="male" <?= old('gender')==='male'?'selected':'' ?>>Male</option>
                    <option value="female" <?= old('gender')==='female'?'selected':'' ?>>Female</option>
                    <option value="other" <?= old('gender')==='other'?'selected':'' ?>>Other</option>
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Age (years)</label><input type="number" name="age" class="form-control" value="<?= esc(old('age')) ?>" placeholder="35" min="0" max="150"></div>
            <div class="col-md-4"><label class="form-label">Date of Birth</label><input type="date" name="dob" class="form-control" value="<?= esc(old('dob')) ?>"></div>
            <div class="col-md-6"><label class="form-label">Mobile Number</label><input type="text" name="mobile" class="form-control" value="<?= esc(old('mobile')) ?>" placeholder="10-digit"></div>
            <div class="col-md-6"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" placeholder="Optional"></div>
            <div class="col-md-4"><label class="form-label">Blood Group</label>
                <select name="blood_group" class="form-select">
                    <option value="">&#8212; Unknown &#8212;</option>
                    <?php foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg): ?><option value="<?= $bg ?>" <?= old('blood_group')===$bg?'selected':'' ?>><?= $bg ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-8"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2"><?= esc(old('address')) ?></textarea></div>
            <div class="col-12"><label class="form-label">Known Allergies</label><input type="text" name="allergies" class="form-control" value="<?= esc(old('allergies')) ?>" placeholder="e.g. Penicillin (or None)"></div>

            <!-- LEGAL CONSENT SECTION -->
            <div class="col-12">
                <div class="border rounded-3 p-3 mt-1" style="background:#f0f9ff;border-color:#bae6fd!important;">
                    <h6 class="fw-bold mb-3" style="color:#0c4a6e;">
                        <i class="fas fa-file-signature me-2 text-primary"></i>
                        &#128221; &#2325;&#2366;&#2344;&#2370;&#2344;&#2368; &#2360;&#2361;&#2350;&#2340;&#2367;
                        <span class="text-muted fw-normal" style="font-size:.75rem;">/ Legal Consent</span>
                    </h6>

                    <!-- Privacy Consent (required) -->
                    <div class="form-check mb-3 p-2 rounded" style="background:#fff;border:1px solid #e0f2fe;">
                        <input class="form-check-input consent-req" type="checkbox" id="privacyConsent" name="privacyConsent" value="1" <?= old('privacyConsent')?'checked':'' ?> required style="width:1.1em;height:1.1em;margin-top:.15em;">
                        <label class="form-check-label ms-1" for="privacyConsent" style="font-size:.85rem;cursor:pointer;">
                            &#2350;&#2376;&#2306;&#2344;&#2375; <a href="<?= base_url('privacy-policy') ?>" target="_blank" class="fw-semibold">&#2327;&#2379;&#2346;&#2344;&#2368;&#2351;&#2340;&#2366; &#2344;&#2368;&#2340;&#2367;</a> &#2346;&#2328;&#2364; &#2354;&#2368; &#2361;&#2376; &#2324;&#2352; &#2360;&#2361;&#2350;&#2340; &#2361;&#2370;&#2306; &#2325;&#2367; &#2350;&#2375;&#2352;&#2368; &#2357;&#2381;&#2351;&#2325;&#2381;&#2340;&#2367;&#2327;&#2340; &#2332;&#2366;&#2344;&#2325;&#2366;&#2352;&#2368; &#2360;&#2369;&#2352;&#2325;&#2381;&#2359;&#2367;&#2340; &#2352;&#2361;&#2375;&#2327;&#2368; &#2310;&#2352; &#2325;&#2375;&#2357;&#2354; &#2907;&#2354;&#2366;&#2332; &#2361;&#2375;&#2340;&#2369; &#2313;&#2346;&#2351;&#2379;&#2327; &#2361;&#2379;&#2327;&#2368;&#2404; <span class="text-danger fw-bold">*</span><br>
                            <small class="text-muted">I have read the <a href="<?= base_url('privacy-policy') ?>" target="_blank">Privacy Policy</a> and agree my health info will be kept secure and used only for treatment.</small>
                        </label>
                    </div>

                    <!-- Terms Consent (required) -->
                    <div class="form-check mb-3 p-2 rounded" style="background:#fff;border:1px solid #e0f2fe;">
                        <input class="form-check-input consent-req" type="checkbox" id="termsConsent" name="termsConsent" value="1" <?= old('termsConsent')?'checked':'' ?> required style="width:1.1em;height:1.1em;margin-top:.15em;">
                        <label class="form-check-label ms-1" for="termsConsent" style="font-size:.85rem;cursor:pointer;">
                            &#2350;&#2376;&#2306; <a href="<?= base_url('terms-conditions') ?>" target="_blank" class="fw-semibold">&#2360;&#2375;&#2357;&#2366; &#2325;&#2368; &#2358;&#2352;&#2381;&#2340;&#2379;&#2306;</a> &#2360;&#2375; &#2360;&#2361;&#2350;&#2340; &#2361;&#2370;&#2306;&#2404; <span class="text-danger fw-bold">*</span><br>
                            <small class="text-muted">I agree to the <a href="<?= base_url('terms-conditions') ?>" target="_blank">Terms &amp; Conditions</a>.</small>
                        </label>
                    </div>

                    <!-- Data Consent (required) -->
                    <div class="form-check mb-3 p-2 rounded" style="background:#fff;border:1px solid #e0f2fe;">
                        <input class="form-check-input consent-req" type="checkbox" id="dataConsent" name="dataConsent" value="1" <?= old('dataConsent')?'checked':'' ?> required style="width:1.1em;height:1.1em;margin-top:.15em;">
                        <label class="form-check-label ms-1" for="dataConsent" style="font-size:.85rem;cursor:pointer;">
                            &#2350;&#2376;&#2306; &#2309;&#2346;&#2344;&#2368; &#2360;&#2381;&#2357;&#2366;&#2360;&#2381;&#2341;&#2381;&#2351; &#2332;&#2366;&#2344;&#2325;&#2366;&#2352;&#2368; &#2311;&#2360; &#2360;&#2367;&#2360;&#2381;&#2335;&#2350; &#2350;&#2375;&#2306; &#2360;&#2381;&#2335;&#2379;&#2352; &#2325;&#2352;&#2344;&#2375; &#2325;&#2368; &#2309;&#2344;&#2369;&#2350;&#2340;&#2367; &#2342;&#2375;&#2340;&#2366;/&#2342;&#2375;&#2340;&#2368; &#2361;&#2370;&#2306;&#2404; <span class="text-danger fw-bold">*</span><br>
                            <small class="text-muted">I consent to store my health information in this system.</small>
                        </label>
                    </div>

                    <!-- Marketing Consent (optional) -->
                    <div class="form-check mb-2 p-2 rounded" style="background:#fafafa;border:1px solid #e5e7eb;">
                        <input class="form-check-input" type="checkbox" id="marketingConsent" name="marketingConsent" value="1" <?= old('marketingConsent')?'checked':'' ?> style="width:1.1em;height:1.1em;margin-top:.15em;">
                        <label class="form-check-label ms-1 text-muted" for="marketingConsent" style="font-size:.82rem;cursor:pointer;">
                            (&#2357;&#2376;&#2325;&#2354;&#2381;&#2346;&#2367;&#2325;) &#2350;&#2376;&#2306; &#2360;&#2381;&#2357;&#2366;&#2360;&#2381;&#2341;&#2381;&#2351; &#2360;&#2306;&#2348;&#2306;&#2343;&#2368; &#2310;&#2346;&#2337;&#2375;&#2335; &#2346;&#2381;&#2352;&#2366;&#2346;&#2381;&#2340; &#2325;&#2352;&#2344;&#2366; &#2330;&#2366;&#2361;&#2340;&#2366;/&#2330;&#2366;&#2361;&#2340;&#2368; &#2361;&#2370;&#2306;&#2404;<br>
                            <small>(Optional) I would like to receive health-related updates.</small>
                        </label>
                    </div>

                    <div class="alert alert-warning py-2 mb-0 mt-2" style="font-size:.78rem;">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>*</strong> &#2360;&#2349;&#2368; &#2332;&#2352;&#2370;&#2352;&#2368; (*) &#2330;&#2375;&#2325;&#2348;&#2377;&#2325;&#2381;&#2360; &#2330;&#2369;&#2344;&#2344;&#2375; &#2325;&#2375; &#2348;&#2366;&#2342; &#2361;&#2368; &#2347;&#2377;&#2352;&#2381;&#2350; &#2360;&#2348;&#2350;&#2367;&#2335; &#2361;&#2379;&#2327;&#2366;&#2404;
                        <span class="text-muted">/ All required (*) checkboxes must be checked.</span>
                    </div>
                </div>
            </div>
            <!-- END LEGAL CONSENT SECTION -->

            <div class="col-12 pt-2"><hr class="mt-0">
                <button type="submit" class="btn btn-primary px-4" id="submitBtn"><i class="fas fa-user-plus me-2"></i>Register Patient</button>
                <a href="<?= base_url('receptionist/patients') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php $this->endSection(); ?>
<?php $this->section('scripts'); ?>
<script>
document.getElementById('patientForm').addEventListener('submit', function(e){
    var unchecked = document.querySelectorAll('.consent-req:not(:checked)');
    if(unchecked.length > 0){
        e.preventDefault();
        unchecked[0].closest('.form-check').style.background='#fee2e2';
        unchecked[0].closest('.form-check').style.borderColor='#ef4444';
        alert('\u26a0\ufe0f \u0915\u0943\u092a\u092f\u093e \u0938\u092d\u0940 \u091c\u0930\u0942\u0930\u0940 (*) \u0938\u0939\u092e\u0924\u093f \u091a\u0947\u0915\u092c\u0949\u0915\u094d\u0938 \u091a\u0941\u0928\u0947\u0902\u0964\nPlease check all required (*) consent checkboxes.');
        unchecked[0].scrollIntoView({behavior:'smooth', block:'center'});
    }
});
document.querySelectorAll('.consent-req').forEach(function(cb){
    cb.addEventListener('change', function(){
        var fc = this.closest('.form-check');
        if(this.checked){ fc.style.background='#f0fdf4'; fc.style.borderColor='#bbf7d0'; }
        else { fc.style.background='#fff'; fc.style.borderColor='#e0f2fe'; }
    });
});
</script>
<?php $this->endSection(); ?>
