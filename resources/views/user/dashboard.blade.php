@extends('user.layout.app')
@section('styles')
@stop
@section('content')
    
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
    </div>
</div>


<!-- Start Monthly Sales -->
<div class="row">
    <div class="col-md-12">
        <div class="card pb-5">
            
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                        <i data-feather="bar-chart" class="widgets-icons"></i>
                    </div>
                    <h5 class="card-title mb-0">Monitoring</h5>
                </div>
            </div>

            <div class="card-body">

                <form action="" method="GET">
                    <div class="row d-flex justify-content-center">
                        <div class="mb-3 col-md-2">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" id="exampleInputEmail1" aria-describedby="emailHelp" required value="{{request('start_date')}}">
                          </div>
                        <div class="mb-3 col-md-2">
                            <label for="exampleInputPassword1" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" id="exampleInputPassword1" required value="{{request('end_date')}}">
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="exampleInputPassword1" class="form-label">Status</label>
                            <select class="form-select" aria-label="Default select example" name="status" required>
                              <option value="">Pilih Status</option>
                              <option value="Active" {{request('status') == 'Active' ? 'selected' :''}}>Active</option>
                              <option value="Waiting for Customer" {{request('status') == 'Waiting for Customer' ? 'selected' :''}}>Waiting for Customer</option>
                              <option value="Waiting for 3rd Party" {{request('status') == 'Waiting for 3rd Party' ? 'selected' :''}}>Waiting for 3rd Party</option>
                              <option value="Waiting for Resolution" {{request('status') == 'Waiting for Resolution' ? 'selected' :''}}>Waiting for Resolution</option>
                              <option value="Waiting for Approval" {{request('status') == 'Waiting for Approval' ? 'selected' :''}}>Waiting for Approval</option>
                              <option value="Resolved" {{request('status') == 'Resolved' ? 'selected' :''}}>Resolved</option>
                              <option value="Closed" {{request('status') == 'Closed' ? 'selected' :''}}>Closed</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="exampleInputPassword1" class="form-label">Service Family</label>
                            <select class="form-select" aria-label="Default select example" name="service_family" required>
                              <option value="">Pilih Service Family</option>
                              @foreach ($services as $service)
                                <option value="{{$service->name}}" {{request('service_family') == $service->name ? 'selected' :''}}>{{$service->name}}</option> 
                              @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-2 pt-4">
                            <button type="submit" class="btn btn-info">Cari</button>
                        </div>
                    </div>
                </form>

                <br>
                <div class="d-flex justify-content-center">
                    <div class="col-12 col-md-9">
                        <p class="text-center fw-bold">Monitoring Ticket</p>
                        <canvas id="chart_1"></canvas>
                    </div>
                </div>
               
            </div>
            
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    const firstChart = document.getElementById('chart_1');
    const chartLabels = {!! json_encode($chartLabels) !!};
    const chartValues = {!! json_encode($chartValues) !!};
  
    new Chart(firstChart, {
      type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: '# of Tickets',
                data: chartValues,
                backgroundColor: '#A2D2DF',
                borderColor: '#A2D2DF',
                borderWidth: 1,
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                },
                datalabels: {
                    display: true,
                    color: 'black', // Warna label
                    anchor: 'end',
                    align: 'top',
                    formatter: function (value) {
                        return value; // Menampilkan nilai data
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        padding: 20 // Tambahkan ruang di atas
                    }
                }
            }
        },
        plugins: [ChartDataLabels] // Aktivasi plugin untuk menampilkan label
    });
  </script>
@endsection

