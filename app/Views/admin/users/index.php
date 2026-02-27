<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>
<div class="page-header">
    <div><h4><i class="fas fa-users me-2 text-primary"></i>User Management</h4></div>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add User</a>
</div>
<div class="form-card mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-sm-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="all" <?= ($role??'all')==='all'?'selected':'' ?>>All Roles</option>
                <option value="doctor" <?= ($role??'')==='doctor'?'selected':'' ?>>Doctors</option>
                <option value="receptionist" <?= ($role??'')==='receptionist'?'selected':'' ?>>Receptionists</option>
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Name, email, mobile..." value="<?= esc($search??'') ?>">
        </div>
        <div class="col-sm-3"><button class="btn btn-primary btn-sm w-100"><i class="fas fa-search me-1"></i>Search</button></div>
    </form>
</div>
<div class="table-card">
    <div class="table-card-header"><h6 class="mb-0 fw-bold" style="font-size:.875rem;">Users (<?= count($users) ?>)</h6></div>
    <?php if (empty($users)): ?>
        <div class="p-4 text-center text-muted"><i class="fas fa-users fa-2x mb-2 d-block"></i>No users found.</div>
    <?php else: ?>
    <div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>#</th><th>Name</th><th>Role</th><th>Mobile</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($users as $i => $u): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar" style="background:<?= $u['role']==='doctor'?'#dbeafe':'#fce7f3' ?>;color:<?= $u['role']==='doctor'?'#1d4ed8':'#be185d' ?>;"><?= strtoupper(substr($u['full_name'],0,1)) ?></div>
                    <div><div class="fw-semibold"><?= $u['role']==='doctor'?'Dr. ':'' ?><?= esc($u['full_name']) ?></div><div class="text-muted" style="font-size:.75rem;"><?= esc($u['email']) ?></div></div>
                </div>
            </td>
            <td><span class="badge" style="font-size:.7rem;"><?= ucfirst($u['role']) ?></span><?php if ($u['role']==='doctor'&&$u['specialization']): ?><div class="text-muted" style="font-size:.7rem;"><?= esc($u['specialization']) ?></div><?php endif; ?></td>
            <td style="font-size:.85rem;"><?= esc($u['mobile']) ?></td>
            <td><span class="badge <?= $u['is_active']?'badge-active':'badge-inactive' ?>"><?= $u['is_active']?'Active':'Inactive' ?></span></td>
            <td>
                <div class="d-flex gap-1">
                    <a href="<?= base_url("admin/users/edit/{$u['id']}") ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                    <form action="<?= base_url("admin/users/toggle/{$u['id']}") ?>" method="POST" class="d-inline"><?= csrf_field() ?>
                        <button class="btn btn-sm <?= $u['is_active']?'btn-outline-warning':'btn-outline-success' ?>" title="Toggle"><i class="fas <?= $u['is_active']?'fa-toggle-off':'fa-toggle-on' ?>"></i></button>
                    </form>
                    <a href="<?= base_url("admin/users/delete/{$u['id']}") ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete <?= esc($u['full_name']) ?>?')"><i class="fas fa-trash"></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
