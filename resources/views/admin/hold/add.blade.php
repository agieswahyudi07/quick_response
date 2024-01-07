@extends('layout/layout')\

@section('main')
<div id="main" class="main">

    <div class="pagetitle">
        <h1>Add {{ $data['title'] }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item active">Add {{ $data['title'] }}</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body mt-3">
                        <h5 class="card-title">Add {{ $data['title'] }}</h5>
                        @include('message/errors')
                        <form class="row g-3" method="POST" action="{{ route('queue.store') }}">
                            @csrf
                            <div class="row mb-3">
                            <label for="txtComplaintName" class="col-sm-2 col-form-label">Complaint</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtComplaintName" name="txtComplaintName" value="{{ Session::get('txtComplaintName') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtComplaintReporter" class="col-sm-2 col-form-label">Reporter</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtComplaintReporter" name="txtComplaintReporter" value="{{ Session::get('txtComplaintReporter') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtComplaintLocation" class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtComplaintLocation" name="txtComplaintLocation" value="{{ Session::get('txtComplaintLocation') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="txtComplaintTime" class="col-sm-2 col-form-label">Time</label>
                                <div class="col-sm-10">
                                <input type="time" class="form-control" id="txtComplaintTime" name="txtComplaintTime" value="{{ Session::get('txtComplaintTime') }}">
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                            <label for="txtComplaintDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="txtComplaintDate" name="txtComplaintDate" value="{{ Session::get('txtComplaintDate') }}">
                            </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="selPriority" name="selPriority">
                                        @if (session()->has('txtPriority'))
                                            <option value="{{ Session::get('selPriority') }}">{{ Session::get('txtPriority') }}</option>
                                        @else
                                            <option value="" selected disabled>Select Priority</option>
                                        @endif
                                        @foreach($data['priority'] as $priority)
                                            <option value="{{ $priority->priority_id }}">{{ $priority->priority_code .'-'. $priority->priority_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                            <label for="txtComplaintDesc" class="col-sm-2 col-form-label">Complaint Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" id="txtComplaintDesc" name="txtComplaintDesc">{{ Session::get('txtComplaintDesc') }}</textarea>
                            </div>
                            </div>
                            
                        
                            <div class="row mb-3">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit Form</button>
                            </div>
                            </div>
                        
                        </form><!-- End General Form Elements -->   
                    </div>
                </div>
            </div>
        </div>
    </section>
  
</div>

 <!-- General Form Elements -->


@endsection