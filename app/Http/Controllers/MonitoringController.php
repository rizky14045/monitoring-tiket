<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use Excel;
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
    public function edit() {

    }
    public function update() {

    }
    public function destroy() {

    }

}
