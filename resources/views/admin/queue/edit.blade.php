@extends('admin/layout/layout')

@section('main')
<div id="main" class="main">

    <div class="pagetitle">
        <h1>Edit {{ $data['title'] }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item active">Edit {{ $data['title'] }}</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body mt-3">
                        <h5 class="card-title">Edit {{ $data['title'] }}</h5>
                        @include('message/errors')
                        <form class="row g-3"  method="POST" action="{{ route('admin.queue.update', $data['complaint']->complaint_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                            <label for="txtComplaintName" class="col-sm-2 col-form-label">Complaint</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtComplaintName" name="txtComplaintName" value="{{ session()->has('txtComplaintName') ? Session::get('txtComplaintName') : $data['complaint']->complaint_name;  }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtComplaintReporter" class="col-sm-2 col-form-label">Reporter</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtComplaintReporter" name="txtComplaintReporter" value="{{ session()->has('txtComplaintName') ? Session::get('txtComplaintName') : $data['complaint']->complaint_reporter;  }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtComplaintLocation" class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtComplaintLocation" name="txtComplaintLocation" value="{{ session()->has('txtComplaintName') ? Session::get('txtComplaintName') : $data['complaint']->complaint_location;  }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                                <label for="txtComplaintTime" class="col-sm-2 col-form-label">Time</label>
                                <div class="col-sm-10">
                                <input type="time" class="form-control" id="txtComplaintTime" name="txtComplaintTime" value="{{ session()->has('txtComplaintName') ? Session::get('txtComplaintName') : $data['complaint']->complaint_time;  }}">
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                            <label for="txtComplaintDate" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="txtComplaintDate" name="txtComplaintDate" value="{{ session()->has('txtComplaintName') ? Session::get('txtComplaintName') : $data['complaint']->complaint_date;  }}">
                            </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-10">
            
                                    <select class="form-select" aria-label="Default select example" id="selPriority" name="selPriority">
                                    @if (session()->has('txtPriority'))
                                      <option value="{{ Session::get('selPriority') }}">{{ Session::get('txtPriority') }}</option>
                                      @foreach ($data['priority'] as $priority)
                                        <option value="{{ $priority->priority_id }}" {{ $data['complaint']->priority_id == $priority->priority_id ? 'selected' : '' }}>
                                            {{ $priority->priority_name }}
                                        </option>
                                      @endforeach
                                    @else
                                      @foreach ($data['priority'] as $priority)
                                        <option value="{{ $priority->priority_id }}" {{ $data['complaint']->priority_id == $priority->priority_id ? 'selected' : '' }}>
                                            {{ $priority->priority_name }}
                                        </option>
                                     @endforeach
            
                                    @endif                          
                                    </select>
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
                            <label for="txtComplaintDesc" class="col-sm-2 col-form-label">Complaint Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" id="txtComplaintDesc" name="txtComplaintDesc">{{ session()->has('txtComplaintDesc') ? Session::get('txtComplaintDesc') : $data['complaint']->complaint_desc; }}</textarea>
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
 <script>
    $(document).ready(function() {

        // Fungsi untuk membuat input uppercase ketika diketikkan
        $('input[type="text"]').on('input', function() {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });

    });
</script>

@endsection