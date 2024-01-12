@extends('admin/layout/layout')

@section('main')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Data {{ $data['title'] }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active">{{ $data['title'] }}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    COMPLAINT DETAILS
                </div>
                <div class="card-body">
                    <h1 class="card-title text-center">{{ $data['complaint']->complaint_id }}</h5>
            
                        @switch($data['complaint']->priority_id)
                        @case(1)
                            <p class="card- text-left">
                                <strong>Priority :</strong>
                                <span  class="badge bg-danger">{{ $data['complaint']->priority->priority_name }}</span><br>
                            </p>
                            @break
                        @case(2)
                            <p class="card- text-left">
                                <strong>Priority :</strong>
                                <span  class="badge bg-warning">{{ $data['complaint']->priority->priority_name }}</span><br>
                            </p>
                            @break
                        @case(3)
                            <p class="card- text-left">
                                <strong>Priority :</strong>
                                <span  class="badge bg-warning">{{ $data['complaint']->priority->priority_name }}</span><br>
                            </p>
                            @break
                        @case(4)
                            <p class="card- text-left">
                                <strong>Priority :</strong>
                                <span  class="badge bg-warning">{{ $data['complaint']->priority->priority_name }}</span><br>
                            </p>
                            @break
                        @case(5)
                            <p class="card- text-left">
                                <strong>Priority :</strong>
                                <span  class="badge bg-primary">{{ $data['complaint']->priority->priority_name }}</span><br>
                            </p>
                            @break
                        @default
                    @endswitch

                        @switch($data['complaint']->status_id)
                            @case(1)
                                <p class="card- text-left">
                                    <strong>Status :</strong>
                                    <span  class="badge bg-danger">{{ $data['complaint']->status->status_name }}</span><br>
                                </p>
                                @break
                            @case(2)
                                <p class="card- text-left">
                                    <strong>Status :</strong>
                                    <span  class="badge bg-primary">{{ $data['complaint']->status->status_name }}</span><br>
                                </p>
                                @break
                            @case(3)
                                <p class="card- text-left">
                                    <strong>Status :</strong>
                                    <span  class="badge bg-success">{{ $data['complaint']->status->status_name }}</span><br>
                                </p>
                                @break
                            @case(4)
                                <p class="card- text-left">
                                    <strong>Status :</strong>
                                    <span  class="badge bg-warning">{{ $data['complaint']->status->status_name }}</span><br>
                                </p>
                                @break
                            @default
                        @endswitch

            
                    <p class="card-text text-left">
                        <strong>Complaint :</strong> {{ $data['complaint']->complaint_name }}<br>
                    </p>
                    <p class="card-text text-left">
                        <strong>Reporter :</strong> {{ $data['complaint']->complaint_reporter }}<br>
                    </p>
                    <p class="card-text text-left">
                        <strong>Location :</strong> {{ $data['complaint']->complaint_location }}<br>
                    </p>
                    <p class="card-text text-left">
                        <strong>Report Time :</strong> {{ $data['complaint']->complaint_time }}<br>
                    </p>
                    <p class="card-text text-left">
                        <strong>Report Date :</strong> {{ $data['complaint']->complaint_date }}<br>
                    </p>
                    @if ($data['complaint']->proceed_at_time)
                        <p class="card-text text-left">
                            <strong>Progress Time :</strong> {{ $data['complaint']->proceed_at_time }}<br>
                        </p>
                    @endif
                    @if ($data['complaint']->proceed_at_date)
                        <p class="card-text text-left">
                            <strong>Progress Date :</strong> {{ $data['complaint']->proceed_at_date }}<br>
                        </p>
                    @endif
                   
                    <a href="{{ route('admin.progress') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                </div>
                <div class="card-footer text-muted">
                </div>
            </div>
            
        </div>
    </div>
</section>

</main><!-- End #main -->


@endsection