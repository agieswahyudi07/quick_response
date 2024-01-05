@extends('layout/layout')

@section('main')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Data {{ $data['title'] }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active">{{ $data['title'] }}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">See by date</h5>
                    @include('message/errors')

                    <!-- Date Selector -->
                    <div class="col-lg-2 mb-3">
                      <label for="dateFilter" class="form-label">Filter by Date:</label>
                      <input type="date" id="dateFilter" class="form-control">
                      <button class="btn btn-primary mt-2" id="applyFilter">Apply Filter</button>
                      <button class="btn btn-secondary mt-2" id="resetFilter">Reset Filter</button>
                      <a href="{{ route('completed.export') }}">
                        <button class="btn btn-outline-success mt-2"><i class="ri ri-file-excel-2-line"></i> Excel Export</button>
                      </a>
                      
                  </div>
                  <!-- End Date Selector -->
                  <form id="filterForm" action="{{ route('completed.filter') }}" method="post" style="display: none;">
                      @csrf
                      <input type="hidden" id="filterDateInput" name="filter_date">
                  </form>

                    <!-- Table with stripped rows -->

                    <table class="table datatable" id="complaintTable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Complaint</th>
                                <th scope="col">Reporter</th>
                                <th scope="col">Time</th>
                                <th scope="col">Date</th>
                                <th scope="col">Location</th>
                                <th scope="col">Completed Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['complaint_date_filter'] as $complaint_filter)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($complaint_filter->priority_id == 1)
                                            <div class="bg-danger">Urgent</div>
                                        @elseif($complaint_filter->priority_id == 2)
                                            <div class="bg-warning">Operational</div>
                                        @elseif($complaint_filter->priority_id == 3)
                                            <div class="bg-primary">Non-Essential</div>
                                        @endif
                                    </td>
                                    <td>{{ $complaint_filter->complaint_name }}</td>
                                    <td>{{ $complaint_filter->complaint_reporter }}</td>
                                    <td>{{ $complaint_filter->complaint_time }}</td>
                                    <td>{{ $complaint_filter->complaint_date }}</td>
                                    <td>{{ $complaint_filter->complaint_location }}</td>
                                    <td>{{ $complaint_filter->complaint_completed_date ? \Carbon\Carbon::parse($complaint_filter->complaint_completed_date)->format('Y-m-d') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $data['title'] }} Recently</h5>
            @include('message/errors')
            
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Priority</th>
                  <th scope="col">Complaint</th>
                  <th scope="col">Reporter</th>
                  <th scope="col">Time</th>
                  <th scope="col">Date</th>
                  <th scope="col">Location</th>
                  <th scope="col">Completed Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data['complaint'] as $complaint)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      @if($complaint->priority_id == 1)
                        <div class="bg-danger">Urgent</div>
                      @elseif($complaint->priority_id == 2)
                        <div class="bg-warning">Operational</div>
                      @elseif($complaint->priority_id == 3)
                        <div class="bg-primary">Non-Essential</div>
                      @endif
                    </td>
                    <td>{{ $complaint->complaint_name }}</td>
                    <td>{{ $complaint->complaint_reporter }}</td>
                    <td>{{ $complaint->complaint_time }}</td>
                    <td>{{ $complaint->complaint_date }}</td>
                    <td>{{ $complaint->complaint_location }}</td>
                    <td>{{ $complaint->complaint_completed_date ? \Carbon\Carbon::parse($complaint->complaint_completed_date)->format('Y-m-d') : '' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->
  
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  
</main><!-- End #main -->

<script>
    $(document).ready(function () {
        $("#applyFilter").on("click", function () {
            var dateFilter = $("#dateFilter").val();
            $("#filterDateInput").val(dateFilter);
            $("#filterForm").submit();
        });

        $("#resetFilter").on("click", function () {
            // Reset the date input
            $("#dateFilter").val('');

            // Clear the filter date in the hidden input
            $("#filterDateInput").val('');

            // Submit the form
            $("#filterForm").submit();
        });
    });
</script>
@endsection