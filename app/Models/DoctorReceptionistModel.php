<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * DoctorReceptionistModel
 *
 * Manages the many-to-many mapping between doctors and receptionists.
 */
class DoctorReceptionistModel extends Model
{
    protected $table = 'doctor_receptionist';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['doctor_id', 'receptionist_id', 'created_by'];
    protected $useTimestamps = false; // Handle created_at manually in raw insert

    /**
     * Assign a receptionist to a doctor.
     * Silently ignores duplicate (unique constraint).
     */
    public function assignReceptionist(int $doctorId, int $receptionistId, int $createdBy): bool
    {
        // Use db->table() directly to avoid stale query builder state on model's insert()
        $exists = $this->db->table($this->table)
            ->where('doctor_id', $doctorId)
            ->where('receptionist_id', $receptionistId)
            ->countAllResults();

        if ($exists > 0) {
            return false; // Already mapped
        }

        return $this->db->table($this->table)->insert([
            'doctor_id' => $doctorId,
            'receptionist_id' => $receptionistId,
            'created_by' => $createdBy,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Remove a doctor-receptionist mapping.
     */
    public function removeMapping(int $doctorId, int $receptionistId): bool
    {
        return $this->where('doctor_id', $doctorId)
            ->where('receptionist_id', $receptionistId)
            ->delete();
    }

    /**
     * Get all doctor IDs assigned to a receptionist.
     */
    public function getDoctorIdsForReceptionist(int $receptionistId): array
    {
        $rows = $this->select('doctor_id')
            ->where('receptionist_id', $receptionistId)
            ->findAll();

        return array_column($rows, 'doctor_id');
    }

    /**
     * Get all doctor records assigned to a receptionist (full user data).
     */
    public function getDoctorsForReceptionist(int $receptionistId): array
    {
        $db = db_connect();
        return $db->table('doctor_receptionist dr')
            ->select('u.id, u.full_name, u.email, u.mobile, u.degree, u.specialization')
            ->join('users u', 'u.id = dr.doctor_id')
            ->where('dr.receptionist_id', $receptionistId)
            ->where('u.is_active', 1)
            ->get()
            ->getResultArray();
    }

    /**
     * Get all receptionists assigned to a doctor (full user data).
     */
    public function getReceptionistsForDoctor(int $doctorId): array
    {
        $db = db_connect();
        return $db->table('doctor_receptionist dr')
            ->select('u.id, u.full_name, u.email, u.mobile')
            ->join('users u', 'u.id = dr.receptionist_id')
            ->where('dr.doctor_id', $doctorId)
            ->where('u.is_active', 1)
            ->get()
            ->getResultArray();
    }

    /**
     * Get all mappings for admin display with full names.
     */
    public function getAllMappings(): array
    {
        $db = db_connect();
        return $db->table('doctor_receptionist dr')
            ->select('dr.id, dr.doctor_id, dr.receptionist_id, dr.created_at,
                      d.full_name AS doctor_name, d.specialization AS doctor_spec,
                      r.full_name AS receptionist_name')
            ->join('users d', 'd.id = dr.doctor_id')
            ->join('users r', 'r.id = dr.receptionist_id')
            ->orderBy('d.full_name')
            ->get()
            ->getResultArray();
    }

    /**
     * Get all doctors with their assigned receptionist count.
     */
    public function getDoctorMappingSummary(): array
    {
        $db = db_connect();
        return $db->table('users u')
            ->select('u.id, u.full_name, u.specialization,
                      COUNT(dr.receptionist_id) AS receptionist_count')
            ->join('doctor_receptionist dr', 'dr.doctor_id = u.id', 'left')
            ->where('u.role', 'doctor')
            ->where('u.is_active', 1)
            ->groupBy('u.id')
            ->get()
            ->getResultArray();
    }
}
