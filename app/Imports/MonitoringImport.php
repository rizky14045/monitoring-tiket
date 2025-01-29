<?php

namespace App\Imports;

use App\Models\Monitoring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MonitoringImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            $existingIncidents = Monitoring::whereIn('incident', $rows->pluck(0))->pluck('incident', 'id');
            $newRecords = [];
            $updatedRecords = [];

            foreach ($rows as $row) {
                if (isset($existingIncidents[$row[0]])) {
                    // Update existing record
                    $updatedRecords[] = [
                        'id' => $existingIncidents[$row[0]],
                        'status' => $row[17],
                        'updated_at' => now(),
                    ];
                } else {
                    // Prepare new record for batch insert
                    $newRecords[] = [
                        'incident' => $row[0],
                        'incident_rec_id' => $row[1],
                        'priority_name' => $row[2],
                        'case_owner_rec_id' => $row[3],
                        'sla_class' => $row[4],
                        'case_owner' => $row[5],
                        'case_owner_email' => $row[6],
                        'unit_level_1' => $row[7],
                        'unit_level_2' => $row[8],
                        'unit_level_3' => $row[9],
                        'complainant_rec_id' => $row[10],
                        'complainant' => $row[11] === 'False' ? false : true,
                        'reported_by' => $row[12],
                        'reported_by_email' => $row[13],
                        'summary' => $row[14],
                        'source' => $row[15],
                        'call_type' => $row[16],
                        'status' => $row[17],
                        'description' => $row[18],
                        'fcr' => $row[19],
                        'service_family' => $row[20],
                        'service_group' => $row[21],
                        'service_type' => $row[22],
                        'cause' => $row[23],
                        'cause_code' => $row[24],
                        'resolution' => $row[25],
                        'send_notif_to_secondary_email' => $row[26] === 'False' ? false : true,
                        'area_ops_safe' => $row[27],
                        'mail_groups_sti_ops' => $row[28],
                        'ticket_created_at' => $this->excelDateToCarbon($row[29]),
                        'ticket_created_by' => $row[30],
                        'task_created_on' => $this->excelDateToCarbon($row[31]),
                        'task_created_by' => $row[32],
                        'task_assign_to' => $row[33],
                        'task_assign_on' => $this->excelDateToCarbon($row[34]),
                        'owner_team' => $row[35],
                        'task_completed_on' => $this->excelDateToCarbon($row[36]),
                        'ticket_resolved_on' => $this->excelDateToCarbon($row[37]),
                        'ticket_resolved_by' => $row[38],
                        'ticket_modified_on' => $this->excelDateToCarbon($row[39]),
                        'ticket_modified_by' => $row[40],
                        'ticket_closed_on' => $this->excelDateToCarbon($row[41]),
                        'ticket_closed_by' => $row[42],
                        'priority' => $row[43],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Batch update using upsert
            if (!empty($updatedRecords)) {
                Monitoring::upsert($updatedRecords, ['id'], ['status', 'updated_at']);
            }

            // Batch insert new records
            if (!empty($newRecords)) {
                Monitoring::insert($newRecords);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Helper function to convert Excel date to Carbon
     */
    private function excelDateToCarbon($excelDate)
    {
        return is_numeric($excelDate) 
            ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($excelDate))->addSeconds(($excelDate - floor($excelDate)) * 86400)->format('Y-m-d H:i:s') 
            : null;
    }
        public function startRow(): int
    {
        return 2;
    }

}
