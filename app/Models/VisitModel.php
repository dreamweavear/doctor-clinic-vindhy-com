<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * VisitModel
 *
 * Manages patient OPD visits with token generation and doctor-linked queries.
 */
class VisitModel extends Model
{
    protected $table = 'visits';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'patient_id', 'doctor_id', 'token_number', 'visit_date',
        'chief_complaint', 'diagnosis', 'weight', 'bp', 'temperature',
        'pulse', 'created_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ----------------------------------------------------------------
    // Token Generation
    // ----------------------------------------------------------------

    /**
     * Generate a daily token number for a doctor.
     * Format: DATE-NNN (e.g., 2024-01-15-005)
     */
    public function generateToken(int $doctorId, string $date): string
    {
        $count = $this->where('doctor_id', $doctorId)
            ->where('visit_date', $date)
            ->countAllResults();

        $next = $count + 1;
        return date('ymd', strtotime($date)) . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    // ----------------------------------------------------------------
    // Queries
    // ----------------------------------------------------------------

    /**
     * Get all visits for a patient (ordered by date desc).
     */
    public function getForPatient(int $patientId): array
    {
        return $this->select('visits.*, u.full_name AS doctor_name')
            ->join('users u', 'u.id = visits.doctor_id')
            ->where('visits.patient_id', $patientId)
            ->orderBy('visits.visit_date', 'DESC')
            ->orderBy('visits.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get today's visits for a specific doctor.
     */
    public function getTodayForDoctor(int $doctorId): array
    {
        return $this->select('visits.*, p.full_name AS patient_name, p.uhid, p.gender, p.age')
            ->join('patients p', 'p.id = visits.patient_id')
            ->where('visits.doctor_id', $doctorId)
            ->where('visits.visit_date', date('Y-m-d'))
            ->orderBy('visits.token_number')
            ->findAll();
    }

    /**
     * Get a visit with patient and doctor details.
     */
    public function getVisitDetails(int $visitId): ?array
    {
        return $this->select('visits.*, 
                              p.full_name AS patient_name, p.uhid, p.gender, p.age, p.mobile AS patient_mobile, p.blood_group,
                              u.full_name AS doctor_name, u.mobile AS doctor_mobile, u.degree, u.specialization, u.address AS doctor_address, u.clinic_name')
            ->join('patients p', 'p.id = visits.patient_id')
            ->join('users u', 'u.id = visits.doctor_id')
            ->where('visits.id', $visitId)
            ->first();
    }

    /**
     * Count today's visits for a doctor.
     */
    public function countTodayForDoctor(int $doctorId): int
    {
        return $this->where('doctor_id', $doctorId)
            ->where('visit_date', date('Y-m-d'))
            ->countAllResults();
    }

    /**
     * Count total visits for a doctor.
     */
    public function countForDoctor(int $doctorId): int
    {
        return $this->where('doctor_id', $doctorId)->countAllResults();
    }
}
