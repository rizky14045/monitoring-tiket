<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\ServiceFamily;
use App\Imports\MonitoringImport;
use App\Http\Controllers\Controller;

class MonitoringController extends Controller
{
    public function index() {
        $data['monitorings'] = Monitoring::paginate(10);
        return view('user.monitoring.index',$data);
    }
    public function create() {

    }
    public function store() {
    }

    public function import(Request $request) {

        try {
            $file = $request->file_upload;
            Excel::import(new MonitoringImport, $file);

            return redirect()->back();

        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function edit($id) {
        $data['monitoring'] = Monitoring::where('id',$id)->first();
        $data['families'] = ServiceFamily::all();
        return view('user.monitoring.edit',$data);

    }
    public function update(Request $request,$id) {

        try {
            Monitoring::where('id',$id)->update([
                'priority_name' => $request->priority_name,
                'summary' => $request->summary,
                'status' => $request->status,
                'service_family' => $request->service_family,
                'service_type' => $request->service_type,
                'ticket_created_at' => $request->ticket_created_at,
                'task_assign_to' => $request->task_assign_to,
                'note' => $request->note,
            ]);
            return redirect()->route('monitoring.index')->with('success', 'monitoring berhasil diupdate');
        } catch (\Throwable $th) {
            throw $th;
        }
   
    }
    public function destroy($id) {
        try {
            Monitoring::where('id',$id)->delete();
            return redirect()->route('monitoring.index')->with('success', 'monitoring berhasil dihapus');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
