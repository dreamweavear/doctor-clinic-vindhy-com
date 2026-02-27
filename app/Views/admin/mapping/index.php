<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header"><h4><i class="fas fa-link me-2 text-primary"></i>Doctor–Receptionist Mapping</h4></div>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="form-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle me-2 text-primary"></i>Assign Receptionist</h6>
            <form action="<?= base_url('admin/mapping/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Doctor *</label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">— Choose Doctor —</option>
                        <?php foreach ($doctors as $d): ?><option value="<?= $d['id'] ?>">Dr. <?= esc($d['full_name']) ?><?= $d['specialization']?' ('.esc($d['specialization']).')':'' ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4"><label class="form-label">Receptionist *</label>
                    <select name="receptionist_id" class="form-select" required>
                        <option value="">— Choose Receptionist —</option>
                        <?php foreach ($receptionists as $r): ?><option value="<?= $r['id'] ?>"><?= esc($r['full_name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-link me-2"></i>Create Mapping</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Mappings (<?= count($mappings) ?>)</h6></div>
            <?php if (empty($mappings)): ?>
                <div class="p-4 text-center text-muted"><i class="fas fa-unlink fa-2x mb-2 d-block"></i>No mappings yet.</div>
            <?php else: ?>
            <div class="table-responsive"><table class="table mb-0">
                <thead><tr><th>Doctor</th><th>Receptionist</th><th>Date</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($mappings as $m): ?>
                <tr>
                    <td><div class="d-flex align-items-center gap-2"><div class="avatar" style="background:#dbeafe;color:#1d4ed8;"><?= strtoupper(substr($m['doctor_name'],0,1)) ?></div><div><div class="fw-semibold">Dr. <?= esc($m['doctor_name']) ?></div><?php if($m['doctor_spec']): ?><div class="text-muted" style="font-size:.72rem;"><?= esc($m['doctor_spec']) ?></div><?php endif; ?></div></div></td>
                    <td><div class="d-flex align-items-center gap-2"><div class="avatar" style="background:#fce7f3;color:#be185d;"><?= strtoupper(substr($m['receptionist_name'],0,1)) ?></div><div class="fw-semibold"><?= esc($m['receptionist_name']) ?></div></div></td>
                    <td class="text-muted" style="font-size:.8rem;"><?= date('d M Y', strtotime($m['created_at'])) ?></td>
                    <td><a href="<?= base_url("admin/mapping/delete/{$m['doctor_id']}/{$m['receptionist_id']}") ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this mapping?')"><i class="fas fa-unlink"></i></a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>
