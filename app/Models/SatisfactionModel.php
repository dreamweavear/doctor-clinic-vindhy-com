<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * SatisfactionModel
 * Tracks doctor's self-satisfaction rating per visit.
 */
class SatisfactionModel extends Model
{
    protected $table = 'doctor_satisfaction';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'doctor_id', 'patient_id', 'visit_id', 'visit_date', 'status', 'reason',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // no updated_at column

    // ----------------------------------------------------------------
    // Save / upsert (one record per visit)
    // ----------------------------------------------------------------

    public function saveSatisfaction(int $doctorId, int $visitId, int $patientId, string $visitDate, string $status, ?string $reason = null): bool
    {
        $db = db_connect();
        // Upsert: if already exists for this visit, update it
        $existing = $db->table($this->table)
            ->where('doctor_id', $doctorId)
            ->where('visit_id', $visitId)
            ->get()->getRowArray();

        if ($existing) {
            return $db->table($this->table)
                ->where('id', $existing['id'])
                ->update(['status' => $status, 'reason' => $reason]);
        }

        return $db->table($this->table)->insert([
            'doctor_id' => $doctorId,
            'patient_id' => $patientId,
            'visit_id' => $visitId,
            'visit_date' => $visitDate,
            'status' => $status,
            'reason' => $reason,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // ----------------------------------------------------------------
    // Dashboard Summary
    // ----------------------------------------------------------------

    public function getSummary(int $doctorId, int $days = 30): array
    {
        $db = db_connect();
        $since = date('Y-m-d', strtotime("-{$days} days"));

        $rows = $db->table($this->table)
            ->select('status, COUNT(*) AS cnt')
            ->where('doctor_id', $doctorId)
            ->where('visit_date >=', $since)
            ->groupBy('status')
            ->get()->getResultArray();

        $total = $sat = $dissat = 0;
        foreach ($rows as $r) {
            $total += (int)$r['cnt'];
            if ($r['status'] === 'satisfied')
                $sat = (int)$r['cnt'];
            if ($r['status'] === 'dissatisfied')
                $dissat = (int)$r['cnt'];
        }

        return [
            'total' => $total,
            'satisfied' => $sat,
            'dissatisfied' => $dissat,
            'rate' => $total > 0 ? round($sat * 100 / $total, 1) : 0,
        ];
    }

    // ----------------------------------------------------------------
    // Monthly trend (last 6 months)
    // ----------------------------------------------------------------

    public function getMonthlyTrend(int $doctorId, int $months = 6): array
    {
        $db = db_connect();
        $since = date('Y-m-d', strtotime("-{$months} months"));

        $rows = $db->table($this->table)
            ->select("DATE_FORMAT(visit_date,'%Y-%m') AS month, status, COUNT(*) AS cnt")
            ->where('doctor_id', $doctorId)
            ->where('visit_date >=', $since)
            ->groupBy("month, status")
            ->orderBy('month', 'ASC')
            ->get()->getResultArray();

        // Pivot into month => [satisfied, dissatisfied]
        $trend = [];
        foreach ($rows as $r) {
            $m = $r['month'];
            if (!isset($trend[$m]))
                $trend[$m] = ['month' => $m, 'satisfied' => 0, 'dissatisfied' => 0];
            $trend[$m][$r['status']] = (int)$r['cnt'];
        }

        // Fill missing months
        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $m = date('Y-m', strtotime("-{$i} months"));
            $result[] = $trend[$m] ?? ['month' => $m, 'satisfied' => 0, 'dissatisfied' => 0];
        }
        return $result;
    }

    // ----------------------------------------------------------------
    // Get all records with patient info (for report table)
    // ----------------------------------------------------------------

    public function getForDoctor(int $doctorId, int $limit = 50): array
    {
        $db = db_connect();
        return $db->table('doctor_satisfaction ds')
            ->select('ds.*, p.full_name AS patient_name, p.uhid, p.mobile')
            ->join('patients p', 'p.id = ds.patient_id')
            ->where('ds.doctor_id', $doctorId)
            ->orderBy('ds.visit_date', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    // ----------------------------------------------------------------
    // 6-month milestone message
    // ----------------------------------------------------------------

    public function getMilestoneMessage(int $doctorId): ?string
    {
        $summary = $this->getSummary($doctorId, 180); // 6 months
        if ($summary['total'] < 10)
            return null; // need enough data

        if ($summary['rate'] >= 85) {
            return "Congratulations! In the last 6 months, you satisfied {$summary['satisfied']} out of {$summary['total']} patients ({$summary['rate']}%). Outstanding performance!";
        }
        elseif ($summary['rate'] >= 70) {
            return "Good work! Your satisfaction rate over 6 months is {$summary['rate']}%. There is still room to improve further!";
        }
        else {
            return "Your 6-month satisfaction rate is {$summary['rate']}%. Keep striving to improve your patient care.";
        }
    }
}
