<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Models\ServiceFamily;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['services'] = ServiceFamily::all();
        return view('user.dashboard', $data);
    }
    public function getMonitoringData(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        $monitoring = Monitoring::whereBetween('ticket_created_at', [$startDate, $endDate])
            ->where('status', $request->status)
            ->whereIn('service_family', $request->service_family)
            ->get();

        // Group data berdasarkan tanggal
        $grouped = $monitoring->groupBy(function ($item) {
            return Carbon::parse($item->ticket_created_at)->format('d F Y');
        });

        // Siapkan data untuk Chart.js
        $chartLabels = $grouped->keys()->toArray();
        $chartValues = $grouped->map(fn($items) => $items->count())->values()->toArray();

        return response()->json([
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
        ]);
    }

    public function getMonitoringDataSecond(Request $request)
    {
        $startDate = Carbon::parse($request->start_date_all)->startOfDay();
        $endDate = Carbon::parse($request->end_date_all)->endOfDay();
        
        $monitoring = Monitoring::whereBetween('ticket_created_at', [$startDate, $endDate])
            ->where('status', $request->status_all)
            ->get();

        // Group data berdasarkan tanggal
        $grouped = $monitoring->groupBy(function ($item) {
            return $item->service_family;
        });

        // Siapkan data untuk Chart.js
        $chartLabels = $grouped->keys()->toArray();
        $chartValues = $grouped->map(fn($items) => $items->count())->values()->toArray();

        return response()->json([
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
        ]);
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
