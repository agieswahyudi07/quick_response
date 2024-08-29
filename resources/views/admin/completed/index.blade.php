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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">See by date</h5>
                    @include('message/errors')

                    <!-- Date Selector -->
                    <div class="col-lg-2 mb-3">
                        <label for="dateFilter" class="form-label">Filter by Date:</label>
                        <input type="date" id="dateFilter" name="filter_date" class="form-control">
                        <button class="btn btn-primary mt-2" id="applyFilter">Apply Filter</button>
                        <button class="btn btn-secondary mt-2" id="resetFilter">Reset Filter</button>
                        <a href="{{ route('admin.completed.export') }}">
                            <button class="btn btn-outline-success mt-2"><i class="ri ri-file-excel-2-line"></i> Excel Export</button>
                        </a>
                    </div>
                    <!-- End Date Selector -->
                    <form id="filterForm" action="{{ route('admin.completed.filter') }}" method="post" style="display: none;" class="mt-3">
                        @csrf
                        <input type="hidden" id="filterDateInput" name="filter_date">
                    </form>

                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table table-striped datatable" id="complaintTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Priority</th>
                                    <th scope="col">Complaint</th>
                                    <th scope="col">Reporter</th>
                                    <th scope="col">Location</th>
                                    {{-- <th scope="col">Report Time</th>
                                    <th scope="col">Report Date</th>
                                    <th scope="col">Progress Time</th>
                                    <th scope="col">Progress Date</th> --}}
                                    <th scope="col">Status</th>
                                    <th scope="col">Completed Time</th>
                                    <th scope="col">Completed Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['complaint'] as $complaint)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($complaint->priority_id == 1)
                                                <div class="badge bg-danger">Urgent</div>
                                            @elseif($complaint->priority_id == 2)
                                                <div class="badge bg-warning">Operational - Umum</div>
                                            @elseif($complaint->priority_id == 3)
                                                <div class="badge bg-warning">Operational - Siswa</div>
                                            @elseif($complaint->priority_id == 4)
                                                <div class="badge bg-warning">Operational - Gukar</div>
                                            @elseif($complaint->priority_id == 5)
                                                <div class="badge bg-primary">Non-Essential</div>
                                            @endif
                                        </td>
                                        <td>{{ $complaint->complaint_name }}</td>
                                        <td>{{ $complaint->complaint_reporter }}</td>
                                        <td>{{ $complaint->complaint_location }}</td>
                                        <td><div class="badge bg-success">Completed</div></td>
                                        <td>{{ $complaint->completed_at_time }}</td>
                                        <td>{{ $complaint->completed_at_date }}</td>
                                        <td>
                                            <a href="{{ route('admin.completed.show', $complaint->complaint_id) }}">
                                                <button class="btn btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Show
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- End Table with stripped rows -->

                </div>
            </div>
        </div>
    </div>
</section>


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