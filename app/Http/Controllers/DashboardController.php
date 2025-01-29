<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\ServiceFamily;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request){
        
        $data['services'] = ServiceFamily::all();
        if ($request->has('start_date') && $request->has('end_date')) {
            // Ubah start_date dan end_date agar mencakup waktu
            $startDate = Carbon::parse($request->start_date)->startOfDay(); // 00:00:00
            $endDate = Carbon::parse($request->end_date)->endOfDay(); // 23:59:59
        
            $monitoring = Monitoring::whereBetween('ticket_created_at', [$startDate, $endDate])
            ->where('status', $request->status)
            ->where('service_family', $request->service_family)
            ->get();
        
            // Group by tanggal dan count data
            $grouped = $monitoring->groupBy(function ($item) {
                return Carbon::parse($item->ticket_created_at)->format('d F Y'); // Format d F Y
            });
        
            // Siapkan label dan nilai untuk Chart.js
            $chartLabels = $grouped->keys()->toArray(); // Tanggal dalam format d F Y
            $chartValues = $grouped->map(function ($items) {
                return $items->count(); // Hitung jumlah tiket
            })->values()->toArray();
        
            $data['chartLabels'] = $chartLabels;
            $data['chartValues'] = $chartValues;
        } else {
            $data['chartLabels'] = [];
            $data['chartValues'] = [];
        }
        return view('user.dashboard',$data);
    }

    public function report(Request $request){
        
        $data =[];
        if ($request->has('start_date') && $request->has('end_date')) {
            // Ubah start_date dan end_date agar mencakup waktu
            $startDate = Carbon::parse($request->start_date)->startOfDay(); // 00:00:00
            $endDate = Carbon::parse($request->end_date)->endOfDay(); // 23:59:59
        
            $monitorings = Monitoring::whereBetween('ticket_created_at', [$startDate, $endDate])
                ->get();
            $data['monitorings'] = $monitorings;
        }
        return view('user.report',$data);
    }
}
