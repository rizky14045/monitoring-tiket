@extends('user.layout.app')
@section('styles')
@stop
@section('content')
    

<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Monitoring</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Monitoring</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="d-flex justify-content-end pe-3 pt-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Import Excel</button>
            </div>
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-5">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center align-middle">No</th>
                                <th scope="col" class="text-center align-middle">Incident</th>
                                <th scope="col" class="text-center align-middle">Priority Name</th>
                                <th scope="col" class="text-center align-middle">Summary</th>
                                <th scope="col" class="text-center align-middle">Status</th>
                                <th scope="col" class="text-center align-middle">Service Family</th>
                                <th scope="col" class="text-center align-middle">Service Type</th>
                                <th scope="col" class="text-center align-middle">Ticket Created On</th>
                                <th scope="col" class="text-center align-middle">Task Assign To</th>
                                <th scope="col" class="text-center align-middle">Keterangan</th>
                                <th scope="col" class="text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $perPage = $monitorings->perPage(); // Jumlah item per halaman
                                $currentPage = $monitorings->currentPage(); // Halaman saat ini
                                $startNumber = ($currentPage - 1) * $perPage + 1; // Nomor awal untuk halaman saat ini
                            @endphp

                            @foreach ($monitorings as $key => $monitoring)
                                <tr class="text-center">
                                    <td>{{ $startNumber + $key }}</td>
                                    <td>{{$monitoring->incident}}</td>
                                    <td>{{$monitoring->priority_name}}</td>
                                    <td>{{$monitoring->summary}}</td>
                                    <td>{{$monitoring->status}}</td>
                                    <td>{{$monitoring->service_family}}</td>
                                    <td>{{$monitoring->service_type}}</td>
                                    <td>{{$monitoring->ticket_created_at}}</td>
                                    <td>{{$monitoring->task_assign_to}}</td>
                                    <td>{{$monitoring->note}}</td>
                                    <td>
                                        <div class="d-flex gap-2">

                                            <a href="{{route('monitoring.edit',['id' => $monitoring->id])}}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{route('monitoring.destroy',['id'=>$monitoring->id])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{$monitorings->links()}}
                </div>
         
            </div> <!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

</div> <!-- end row -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Import</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('monitoring.import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">File Upload</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name="file_upload" accept=".xlsx">
              </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Import</button>
        </div>
    </form>
      </div>
    </div>
  </div>
  
@endsection

