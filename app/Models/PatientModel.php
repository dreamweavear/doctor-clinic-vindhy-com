<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * PatientModel
 *
 * Enforces data isolation:
 * - Doctors see only their own patients (doctor_id = their user ID)
 * - Receptionists see patients of their assigned doctors
 * - Admins see all patients
 */
class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'doctor_id', 'uhid', 'full_name', 'gender', 'dob', 'age',
        'mobile', 'email', 'address', 'blood_group', 'allergies', 'registered_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ----------------------------------------------------------------
    // UHID Generation
    // ----------------------------------------------------------------

    /**
     * Generate the next unique UHID (e.g., UHID-000123).
     */
    public function generateUHID(): string
    {
        $last = $this->select('id')->orderBy('id', 'DESC')->first();
        $next = $last ? ($last['id'] + 1) : 1;
        return 'UHID-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }

    // ----------------------------------------------------------------
    // Data-Isolated Queries
    // ----------------------------------------------------------------

    /**
     * Get patients for a specific doctor only.
     * Used by Doctor module.
     */
    public function getForDoctor(int $doctorId, string $search = ''): array
    {
        $builder = $this->select('patients.*, u.full_name AS doctor_name')
            ->join('users u', 'u.id = patients.doctor_id')
            ->where('patients.doctor_id', $doctorId);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('patients.full_name', $search)
                ->orLike('patients.mobile', $search)
                ->orLike('patients.uhid', $search)
                ->groupEnd();
        }

        return $builder->orderBy('patients.created_at', 'DESC')->findAll();
    }

    /**
     * Get patients for a receptionist's assigned doctors.
     * Used by Receptionist module.
     */
    public function getForReceptionist(int $receptionistId, string $search = ''): array
    {
        $drModel = new DoctorReceptionistModel();
        $doctorIds = $drModel->getDoctorIdsForReceptionist($receptionistId);

        if (empty($doctorIds)) {
            return [];
        }

        $builder = $this->select('patients.*, u.full_name AS doctor_name')
            ->join('users u', 'u.id = patients.doctor_id')
            ->whereIn('patients.doctor_id', $doctorIds);

        if (!empty($search)) {
            $builder->groupStart()
                ->like('patients.full_name', $search)
                ->orLike('patients.mobile', $search)
                ->orLike('patients.uhid', $search)
                ->groupEnd();
        }

        return $builder->orderBy('patients.created_at', 'DESC')->findAll();
    }

    /**
     * Get ALL patients for admin.
     */
    public function getAll(string $search = ''): array
    {
        $builder = $this->select('patients.*, u.full_name AS doctor_name')
            ->join('users u', 'u.id = patients.doctor_id');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('patients.full_name', $search)
                ->orLike('patients.mobile', $search)
                ->orLike('patients.uhid', $search)
                ->groupEnd();
        }

        return $builder->orderBy('patients.created_at', 'DESC')->findAll();
    }

    /**
     * Get a single patient with doctor details.
     * Also verifies ownership based on role.
     *
     * @param int    $patientId
     * @param string $role
     * @param int    $userId     The logged-in user's ID
     */
    public function getPatientWithOwnership(int $patientId, string $role, int $userId): ?array
    {
        $builder = $this->select('patients.*, u.full_name AS doctor_name, u.mobile AS doctor_mobile,
                                  u.address AS doctor_address, u.degree AS doctor_degree,
                                  u.specialization AS doctor_specialization, u.clinic_name')
            ->join('users u', 'u.id = patients.doctor_id')
            ->where('patients.id', $patientId);

        if ($role === 'doctor') {
            $builder->where('patients.doctor_id', $userId);
        }
        elseif ($role === 'receptionist') {
            $drModel = new DoctorReceptionistModel();
            $doctorIds = $drModel->getDoctorIdsForReceptionist($userId);
            if (empty($doctorIds))
                return null;
            $builder->whereIn('patients.doctor_id', $doctorIds);
        }
        // Admin sees all — no extra where clause

        return $builder->first();
    }

    /**
     * Count patients for a doctor.
     */
    public function countForDoctor(int $doctorId): int
    {
        return $this->where('doctor_id', $doctorId)->countAllResults();
    }

    /**
     * Count patients for a receptionist's doctors.
     */
    public function countForReceptionist(int $receptionistId): int
    {
        $drModel = new DoctorReceptionistModel();
        $doctorIds = $drModel->getDoctorIdsForReceptionist($receptionistId);
        if (empty($doctorIds))
            return 0;
        return $this->whereIn('doctor_id', $doctorIds)->countAllResults();
    }
}
