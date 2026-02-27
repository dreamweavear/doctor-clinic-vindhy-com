<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * PrescriptionModel
 *
 * Manages prescriptions and their medicines.
 * Uses a transaction to save prescription + medicines atomically.
 */
class PrescriptionModel extends Model
{
    protected $table = 'prescriptions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'visit_id', 'patient_id', 'doctor_id', 'notes', 'followup_date',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ----------------------------------------------------------------
    // Create with Medicines (Transaction)
    // ----------------------------------------------------------------

    public function createWithMedicines(array $prescriptionData, array $medicines)
    {
        $db = db_connect();
        $db->transBegin();

        try {
            $this->insert($prescriptionData);
            $prescriptionId = $this->getInsertID();

            if (!$prescriptionId) {
                $db->transRollback();
                return false;
            }

            if (!empty($medicines)) {
                $medicineRows = [];
                foreach ($medicines as $idx => $med) {
                    if (!empty(trim($med['medicine_name'] ?? ''))) {
                        $medicineRows[] = [
                            'prescription_id' => $prescriptionId,
                            'medicine_name'  => $med['medicine_name'],
                            'dosage'         => $med['dosage'] ?? '',
                            'frequency'      => $med['frequency'] ?? '',
                            'duration'       => $med['duration'] ?? '',
                            'instructions'   => $med['instructions'] ?? '',
                            'sort_order'     => $idx,
                        ];
                    }
                }
                if (!empty($medicineRows)) {
                    $db->table('prescription_medicines')->insertBatch($medicineRows);
                }
            }

            if (!empty($prescriptionData['followup_date'])) {
                $db->table('followups')->insert([
                    'patient_id'    => $prescriptionData['patient_id'],
                    'doctor_id'     => $prescriptionData['doctor_id'],
                    'visit_id'      => $prescriptionData['visit_id'],
                    'followup_date' => $prescriptionData['followup_date'],
                    'status'        => 'pending',
                ]);
            }

            $db->transCommit();
            return $prescriptionId;

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'PrescriptionModel::createWithMedicines - ' . $e->getMessage());
            return false;
        }
    }

    // ----------------------------------------------------------------
    // Queries
    // ----------------------------------------------------------------

    public function getForPatient(int $patientId): array
    {
        $db = db_connect();
        return $db->table('prescriptions p')
            ->select('p.*, v.visit_date, v.chief_complaint')
            ->join('visits v', 'v.id = p.visit_id')
            ->where('p.patient_id', $patientId)
            ->orderBy('v.visit_date', 'DESC')
            ->get()->getResultArray();
    }

    public function getForVisit(int $visitId): ?array
    {
        $db = db_connect();
        $row = $db->table('prescriptions')->where('visit_id', $visitId)->get()->getRowArray();
        return $row ?: null;
    }

    /**
     * Get previous prescriptions for a patient (excluding current visit).
     * Each row includes its medicines array.
     */
    public function getPreviousForPatient(int $patientId, int $excludeVisitId, int $limit = 3): array
    {
        $db = db_connect();

        $rows = $db->table('prescriptions p')
            ->select('p.id, p.notes, p.followup_date, p.created_at,
                      v.visit_date, v.chief_complaint, v.token_number')
            ->join('visits v', 'v.id = p.visit_id')
            ->where('p.patient_id', $patientId)
            ->where('p.visit_id !=', $excludeVisitId)
            ->orderBy('v.visit_date', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();

        foreach ($rows as &$row) {
            $row['medicines'] = $db->table('prescription_medicines')
                ->select('medicine_name, dosage, frequency, duration')
                ->where('prescription_id', $row['id'])
                ->orderBy('sort_order')
                ->get()->getResultArray();
        }
        unset($row);

        return $rows;
    }

    /**
     * Get a full prescription with medicines and patient/doctor info.
     */
    public function getFullPrescription(int $prescriptionId): ?array
    {
        $db = db_connect();

        $prescription = $db->table('prescriptions p')
            ->select('p.*,
                      pt.full_name AS patient_name, pt.uhid, pt.gender, pt.age,
                      pt.mobile AS patient_mobile, pt.address AS patient_address, pt.blood_group,
                      v.visit_date, v.chief_complaint, v.diagnosis, v.token_number,
                      u.full_name AS doctor_name, u.mobile AS doctor_mobile, u.email AS doctor_email,
                      u.degree, u.specialization, u.address AS doctor_address, u.clinic_name')
            ->join('patients pt', 'pt.id = p.patient_id')
            ->join('visits v',    'v.id = p.visit_id')
            ->join('users u',     'u.id = p.doctor_id')
            ->where('p.id', $prescriptionId)
            ->get()->getRowArray();

        if (!$prescription) return null;

        $prescription['medicines'] = $db->table('prescription_medicines')
            ->where('prescription_id', $prescriptionId)
            ->orderBy('sort_order')
            ->get()->getResultArray();

        // Previous visits (for print)
        $prescription['prev_visits'] = $this->getPreviousForPatient(
            (int)$prescription['patient_id'],
            (int)$prescription['visit_id'],
            2
        );

        return $prescription;
    }
}