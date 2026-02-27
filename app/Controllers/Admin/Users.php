<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

/**
 * Admin Users Controller
 *
 * Full CRUD for doctors and receptionists.
 */
class Users extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $role = $this->request->getGet('role') ?? 'all';
        $search = $this->request->getGet('search') ?? '';

        $builder = $this->userModel->where('role !=', 'admin');

        if ($role !== 'all') {
            $builder->where('role', $role);
        }
        if (!empty($search)) {
            $builder->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('mobile', $search)
                ->groupEnd();
        }

        $users = $builder->orderBy('role')->orderBy('full_name')->findAll();

        return view('admin/users/index', [
            'title' => 'User Management | Admin',
            'users' => $users,
            'role' => $role,
            'search' => $search,
            'page' => 'admin_users',
        ]);
    }

    public function create()
    {
        return view('admin/users/create', [
            'title' => 'Create User | Admin',
            'page' => 'admin_users',
        ]);
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|max_length[200]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'mobile' => 'required|max_length[15]|is_unique[users.mobile]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[doctor,receptionist]',
            'username' => 'required|max_length[100]|is_unique[users.username]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'mobile' => $this->request->getPost('mobile'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
            'is_active' => 1,
            'created_by' => session()->get('user_id'),
        ];

        // Doctor-specific fields
        if ($data['role'] === 'doctor') {
            $data['degree'] = $this->request->getPost('degree');
            $data['specialization'] = $this->request->getPost('specialization');
            $data['address'] = $this->request->getPost('address');
            $data['clinic_name'] = $this->request->getPost('clinic_name');
        }

        $this->userModel->skipValidation(true)->insert($data);

        return redirect()->to(base_url('admin/users'))->with('success', 'User created successfully.');
    }

    public function edit(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user || $user['role'] === 'admin') {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        return view('admin/users/edit', [
            'title' => 'Edit User | Admin',
            'user' => $user,
            'page' => 'admin_users',
        ]);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user || $user['role'] === 'admin') {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $emailRule = "required|valid_email|is_unique[users.email,id,{$id}]";
        $mobileRule = "required|max_length[15]|is_unique[users.mobile,id,{$id}]";

        $rules = [
            'full_name' => 'required|max_length[200]',
            'email' => $emailRule,
            'mobile' => $mobileRule,
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'mobile' => $this->request->getPost('mobile'),
            'is_active' => (int)$this->request->getPost('is_active'),
        ];

        // Update password only if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            if (strlen($password) < 6) {
                return redirect()->back()->withInput()->with('error', 'Password must be at least 6 characters.');
            }
            $data['password'] = $password;
        }

        // Doctor-specific fields
        if ($user['role'] === 'doctor') {
            $data['degree'] = $this->request->getPost('degree');
            $data['specialization'] = $this->request->getPost('specialization');
            $data['address'] = $this->request->getPost('address');
            $data['clinic_name'] = $this->request->getPost('clinic_name');
        }

        $this->userModel->update($id, $data);

        return redirect()->to(base_url('admin/users'))->with('success', 'User updated successfully.');
    }

    public function delete(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user || $user['role'] === 'admin') {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $this->userModel->delete($id);
        return redirect()->to(base_url('admin/users'))->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(int $id)
    {
        $user = $this->userModel->find($id);
        if (!$user || $user['role'] === 'admin') {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $this->userModel->update($id, ['is_active' => $user['is_active'] ? 0 : 1]);
        $status = $user['is_active'] ? 'deactivated' : 'activated';
        return redirect()->to(base_url('admin/users'))->with('success', "User {$status} successfully.");
    }
}
