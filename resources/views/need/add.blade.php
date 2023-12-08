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
                            <label for="txtNeedName" class="col-sm-2 col-form-label">Item Need</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtNeedName" name="txtNeedName" value="{{ Session::get('txtNeedName') }}">git
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtNeedPrice" class="col-sm-2 col-form-label">Item Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtNeedPrice" name="txtNeedPrice" value="{{ Session::get('txtNeedPrice') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtNeedLocation" class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtNeedLocation" name="txtNeedLocation" value="{{ Session::get('txtNeedLocation') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="txtNeedTime" class="col-sm-2 col-form-label">Time</label>
                                <div class="col-sm-10">
                                <input type="time" class="form-control" id="txtNeedTime" name="txtNeedTime" value="{{ Session::get('txtNeedTime') }}">
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                            <label for="txtNeedDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="txtNeedDate" name="txtNeedDate" value="{{ Session::get('txtNeedDate') }}">
                            </div>
                            </div>

                            {{-- <div class="row mb-3">
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
                            </div> --}}
                            
                            <div class="row mb-3">
                            <label for="txtNeedDesc" class="col-sm-2 col-form-label">Complaint Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" id="txtNeedDesc" name="txtNeedDesc">{{ Session::get('txtNeedDesc') }}</textarea>
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