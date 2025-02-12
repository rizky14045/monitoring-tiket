@extends('user.layout.app')
@section('styles')
@stop
@section('content')
    
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Report</h4>
    </div>
</div>


<!-- Start Monthly Sales -->
<div class="row">
    <div class="col-md-12">
        <div class="card pb-5">
            
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                        <i data-feather="table" class="widgets-icons"></i>
                    </div>
                    <h5 class="card-title mb-0">Report</h5>
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
                        <div class="mb-3 col-md-2 pt-4">
                            <button type="submit" class="btn btn-info">Cari</button>
                        </div>
                    </div>
                </form>

                <br>
                @isset($monitorings)
                    
                <button class="btn btn-sm btn-success mb-3" onclick="ExportToExcel('xlsx')" type="button">Download</button>
                    <div class="d-flex justify-content-center">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-5" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle">No</th>
                                        <th scope="col" class="text-center align-middle">Incident</th>
                                        {{-- <th scope="col" class="text-center align-middle">Priority Name</th> --}}
                                        <th scope="col" class="text-center align-middle">Summary</th>
                                        <th scope="col" class="text-center align-middle">Status</th>
                                        <th scope="col" class="text-center align-middle">Service Family</th>
                                        {{-- <th scope="col" class="text-center align-middle">Service Type</th> --}}
                                        <th scope="col" class="text-center align-middle">Ticket Created On</th>
                                        <th scope="col" class="text-center align-middle">Task Assign To</th>
                                        <th scope="col" class="text-center align-middle">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
        
                                    @foreach ($monitorings as $key => $monitoring)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$monitoring->incident}}</td>
                                            {{-- <td>{{$monitoring->priority_name}}</td> --}}
                                            <td>{{$monitoring->summary}}</td>
                                            <td>{{$monitoring->status}}</td>
                                            <td>{{$monitoring->service_family}}</td>
                                            {{-- <td>{{$monitoring->service_type}}</td> --}}
                                            <td>{{$monitoring->ticket_created_at}}</td>
                                            <td>{{$monitoring->task_assign_to}}</td>
                                            <td>{{$monitoring->note}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endisset
               
            </div>
            
        </div>
    </div>

</div>
@endsection
@section('scripts')

@endsection

