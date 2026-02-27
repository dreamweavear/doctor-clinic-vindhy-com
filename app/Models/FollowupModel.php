<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * FollowupModel
 */
class FollowupModel extends Model
{
    protected $table = 'followups';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'patient_id', 'doctor_id', 'visit_id', 'followup_date', 'notes', 'status',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    /**
     * Get upcoming followups for a doctor.
     */
    public function getUpcomingForDoctor(int $doctorId, int $days = 7): array
    {
        return $this->select('followups.*, p.full_name AS patient_name, p.uhid, p.mobile AS patient_mobile')
            ->join('patients p', 'p.id = followups.patient_id')
            ->where('followups.doctor_id', $doctorId)
            ->where('followups.status', 'pending')
            ->where('followups.followup_date >=', date('Y-m-d'))
            ->where('followups.followup_date <=', date('Y-m-d', strtotime("+{$days} days")))
            ->orderBy('followups.followup_date')
            ->findAll();
    }

    /**
     * Count pending followups for doctor.
     */
    public function countPendingForDoctor(int $doctorId): int
    {
        return $this->where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->where('followup_date >=', date('Y-m-d'))
            ->countAllResults();
    }
}
