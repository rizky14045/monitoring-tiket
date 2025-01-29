@extends('user.layout.app')
@section('styles')
<style>
    .accordion-button::after {
        filter: invert(100%);
    }
</style>
@stop
@section('content')
    

<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-semibold m-0">Monitoring</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Ubah Data Monitoring</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('monitoring.update',['id'=>$monitoring->id])}}" class="my-4" method="POST">
                    @csrf
                    @method('PATCH')
                    <!-- Formulir Pendaftaran -->
                    <div class="col-xl-6">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Priority Name</label>
                            <input class="form-control" name="priority_name" type="text" id="username" required="" value="{{$monitoring->priority_name}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Summary</label>
                            <input class="form-control" name="summary" type="text" id="username" required="" value="{{$monitoring->summary}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputPassword1" class="form-label">Status</label>
                            <select class="form-select" aria-label="Default select example" name="status" required>
                              <option value="">Pilih Status</option>
                              <option value="Active" {{$monitoring->status == 'Active' ? 'selected' :''}}>Active</option>
                              <option value="Waiting for Customer" {{$monitoring->status == 'Waiting for Customer' ? 'selected' :''}}>Waiting for Customer</option>
                              <option value="Waiting for 3rd Party" {{$monitoring->status == 'Waiting for 3rd Party' ? 'selected' :''}}>Waiting for 3rd Party</option>
                              <option value="Waiting for Resolution" {{$monitoring->status == 'Waiting for Resolution' ? 'selected' :''}}>Waiting for Resolution</option>
                              <option value="Waiting for Approval" {{$monitoring->status == 'Waiting for Approval' ? 'selected' :''}}>Waiting for Approval</option>
                              <option value="Resolved" {{$monitoring->status == 'Resolved' ? 'selected' :''}}>Resolved</option>
                              <option value="Closed" {{$monitoring->status == 'Closed' ? 'selected' :''}}>Closed</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputPassword1" class="form-label">Service Family</label>
                            <select class="form-select" aria-label="Default select example" name="service_family" required>
                              <option value="">Pilih Service Family</option>
                              @foreach ($families as $family)
                                  <option value="{{$family->name}}" {{$family->name == $monitoring->service_family ? 'selected' :''}}> {{$family->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Service Type</label>
                            <input class="form-control" name="service_type" type="text" id="username" required="" value="{{$monitoring->service_type}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Ticket Created On</label>
                            <input class="form-control" name="ticket_created_at" type="datetime-local" id="username" required="" value="{{$monitoring->ticket_created_at}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Task Assign To</label>
                            <input class="form-control" name="task_assign_to" type="text" id="username" required="" value="{{$monitoring->task_assign_to}}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Keterangan</label>
                            <input class="form-control" name="note" type="text" id="username" required="" value="{{$monitoring->note}}">
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-end">

                                    <a href="{{route('monitoring.index')}}" class="btn btn-danger"> Back</a>
                                    <button class="btn btn-primary" type="submit"> Ubah</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
         
            </div> <!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div> <!-- end row -->
@endsection

