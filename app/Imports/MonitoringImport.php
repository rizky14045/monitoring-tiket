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
            foreach ($rows as $row) 
                {
                    $monitoring = Monitoring::where('incident',$row[0])->first();
                    if ($monitoring){
                        $monitoring->status = $row[17];
                        $monitoring->save();
                    }else{

                        Monitoring::create([
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
                            'complainant' => $row[11] == 'False' ? false : true,
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
                            'send_notif_to_secondary_email' => $row[26] == 'False' ? false : true,
                            'area_ops_safe' => $row[27],
                            'mail_groups_sti_ops' => $row[28],
                            'ticket_created_at' => is_numeric($row[29]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[29]))->addSeconds(($row[29] - floor($row[29])) * 86400)->format('Y-m-d H:i:s') : null,
                            'ticket_created_by' => $row[30],
                            'task_created_on' => is_numeric($row[31]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[31]))->addSeconds(($row[31] - floor($row[31])) * 86400)->format('Y-m-d H:i:s') : null,
                            'task_created_by' => $row[32],
                            'task_assign_to' => $row[33],
                            'task_assign_on' => is_numeric($row[34]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[34]))->addSeconds(($row[34] - floor($row[34])) * 86400)->format('Y-m-d H:i:s') : null,
                            'owner_team' => $row[35],
                            'task_completed_on' => is_numeric($row[36]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[36]))->addSeconds(($row[36] - floor($row[36])) * 86400)->format('Y-m-d H:i:s') : null,
                            'ticket_resolved_on' => is_numeric($row[37]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[37]))->addSeconds(($row[37] - floor($row[37])) * 86400)->format('Y-m-d H:i:s') : null,
                            'ticket_resolved_by' => $row[38],
                            'ticket_modified_on' => is_numeric($row[39]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[39]))->addSeconds(($row[39] - floor($row[39])) * 86400)->format('Y-m-d H:i:s') : null,
                            'ticket_modified_by' => $row[40],
                            'ticket_closed_on' => is_numeric($row[41]) ? Carbon::create(1900, 1, 1)->subDays(2)->addDays(floor($row[41]))->addSeconds(($row[41] - floor($row[41])) * 86400)->format('Y-m-d H:i:s') : null,
                            'ticket_closed_by' => $row[42],
                            'priority' => $row[43],
                        ]);
                    }   
                }
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        
    }
    public function startRow(): int
    {
        return 2;
    }

}
