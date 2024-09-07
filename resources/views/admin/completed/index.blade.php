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
                            <label for="dateFilter" class="form-label">Filter by Date:</label>
                            <div class="d-flex flex-row justify-content-start mb-3 col-lg-8 ">
                                <input type="date" id="dateFromFilter" name="dateFromFilter" class="form-control mx-1"
                                    style="width: 12rem; height: 3rem"
                                    value="{{ old('dateFromFilter', Session::get('dateFromFilter')) }}">
                                <div class="invalid-feedback"></div>
                                <input type="date" id="dateToFilter" name="dateToFilter" class="form-control mx-1"
                                    style="width: 12rem; height: 3rem"
                                    value="{{ old('dateToFilter', Session::get('dateToFilter')) }}">
                                <div class="invalid-feedback"></div>

                                <button class="btn btn-primary mt-2 w-2 mx-2" id="applyFilter" name="applyFilter">Apply
                                    Filter</button>
                                <a href="{{ route('admin.completed') }}">
                                    <button class="btn btn-secondary mt-2 mx-2" id="resetFilter" name="resetFilter">Reset
                                        Filter</button>
                                </a>
                                <form id="filterForm" name="filterForm" action="{{ route('admin.completed.filter') }}"
                                    method="post" style="display: none;" class="mt-3">
                                    @csrf
                                    <input type="hidden" id="filterFromDateInput" name="filterFromDateInput">
                                    <input type="hidden" id="filterToDateInput" name="filterToDateInput">
                                </form>
                            </div>
                            <a href="{{ route('admin.completed.export') }}">
                                <button class="btn btn-outline-success mt-2"><i class="ri ri-file-excel-2-line"></i>
                                    Excel Export</button>
                            </a>
                            <!-- End Date Selector -->


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
                                                    @if ($complaint->priority_id == 1)
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
                                                <td>
                                                    <div class="badge bg-success">Completed</div>
                                                </td>
                                                <td>{{ $complaint->completed_at_time }}</td>
                                                <td>{{ $complaint->completed_at_date }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.completed.show', $complaint->complaint_id) }}">
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
            $(document).ready(function() {
                $('#applyFilter').on("click", function() {
                    let dateFromFilter = $("#dateFromFilter").val();
                    let dateToFilter = $("#dateToFilter").val();

                    $("#filterFromDateInput").val(dateFromFilter);
                    $("#filterToDateInput").val(dateToFilter);
                    $('#applyFilter').val('processing...');
                    $('#applyFilter').prop('disabled', true);
                    $("#filterForm").submit();

                });

                $("#resetFilter").on("click", function() {
                    // Reset the date input
                    $("#dateFilter").val('');

                    // Clear the filter date in the hidden input
                    $("#filterFromDateInput").val('');
                    $("#filterToDateInput").val('');

                    // Submit the form
                    $("#filterForm").submit();
                });
            });
        </script>
    @endsection
