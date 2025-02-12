@extends('user.layout.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@stop

@section('content')

<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
    </div>
</div>

<!-- Start Monitoring -->
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
                <form id="filter-form">
                    <div class="row d-flex justify-content-center">
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Active">Active</option>
                                <option value="Waiting for Customer">Waiting for Customer</option>
                                <option value="Waiting for 3rd Party">Waiting for 3rd Party</option>
                                <option value="Waiting for Resolution">Waiting for Resolution</option>
                                <option value="Waiting for Approval">Waiting for Approval</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Service Family</label>
                            <select class="form-control select-2" name="service_family[]" required multiple>
                                @foreach ($services as $service)
                                    <option value="{{ $service->name }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-2 pt-4">
                            <button type="button" class="btn btn-info" id="loadMonitoring1">Cari</button>
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
        <div class="second-card card pb-5">   
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                        <i data-feather="bar-chart" class="widgets-icons"></i>
                    </div>
                    <h5 class="card-title mb-0">Monitoring</h5>
                </div>
            </div>

            <div class="card-body">
                <form id="filter-form-2">
                    <div class="row d-flex justify-content-center">
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date_all" required>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date_all" required>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status_all" required>
                                <option value="">Pilih Status</option>
                                <option value="Active">Active</option>
                                <option value="Waiting for Customer">Waiting for Customer</option>
                                <option value="Waiting for 3rd Party">Waiting for 3rd Party</option>
                                <option value="Waiting for Resolution">Waiting for Resolution</option>
                                <option value="Waiting for Approval">Waiting for Approval</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-2 pt-4">
                            <button type="button" class="btn btn-info" id="loadMonitoring2">Cari</button>
                        </div>
                    </div>
                </form>

                <br>
                <div class="d-flex justify-content-center">
                    <div class="col-12 col-md-9">
                        <p class="text-center fw-bold">Monitoring Ticket</p>
                        <canvas id="chart_2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select-2').select2({ placeholder: "Pilih Service Family" });
       
    });
</script>
<script>
    $(document).ready(function(){
        let chartMonitoring1, chartMonitoring2;

        $('#loadMonitoring1').click(function() {
            let startDate = $('input[name="start_date"]').val();
            let endDate = $('input[name="end_date"]').val();
            let status = $('select[name="status"]').val();
            let serviceFamily = $('select[name="service_family[]"]').val();

            if(chartMonitoring1) {
                chartMonitoring1.destroy(); // Hancurkan chart sebelumnya jika ada
            }

            $.ajax({
                url: '{{ route('monitoring.data') }}',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    status: status,
                    service_family: serviceFamily,
                },
                success: function(response) {
                    $('.chart-monitoring-1').show();

                    const ctx = document.getElementById('chart_1').getContext('2d');
                    chartMonitoring1 = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.chartLabels,
                            datasets: [{
                                label: '# of Tickets',
                                data: response.chartValues,
                                backgroundColor: '#A2D2DF',
                                borderColor: '#A2D2DF',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                legend: { display: false }, // Menghilangkan legend
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    color: 'black',
                                    font: { weight: 'normal', size: 14 },
                                    formatter: (value) => value // Menampilkan angka di atas batang
                                }
                            },
                            scales: {
                                y: { beginAtZero: true }
                            }
                        },
                        plugins: [ChartDataLabels] // Aktifkan plugin datalabels
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#loadMonitoring2').click(function() {
            let startDate = $('input[name="start_date_all"]').val();
            let endDate = $('input[name="end_date_all"]').val();
            let status = $('select[name="status_all"]').val();

            if(chartMonitoring2) {
                chartMonitoring2.destroy(); // Hancurkan chart sebelumnya jika ada
            }

            $.ajax({
                url: '{{ route('monitoring.data2') }}',
                method: 'GET',
                data: {
                    start_date_all: startDate,
                    end_date_all: endDate,
                    status_all: status,
                },
                success: function(response) {
                    console.log(response);
                    $('.chart-monitoring-2').show();

                    const ctx = document.getElementById('chart_2').getContext('2d');
                    chartMonitoring2 = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.chartLabels,
                            datasets: [{
                                label: '# of Tickets',
                                data: response.chartValues,
                                backgroundColor: '#A2D2DF',
                                borderColor: '#A2D2DF',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                legend: { display: false }, // Menghilangkan legend
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    color: 'black',
                                    font: { weight: 'normal', size: 14 },
                                    formatter: (value) => value // Menampilkan angka di atas batang
                                }
                            },
                            scales: {
                                y: { beginAtZero: true }
                            }
                        },
                        plugins: [ChartDataLabels] // Aktifkan plugin datalabels
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
@endsection
