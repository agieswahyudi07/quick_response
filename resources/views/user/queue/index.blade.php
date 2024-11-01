@extends('user/layout/layout')

@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data {{ $data['title'] }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
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
                            <h5 class="card-title">{{ $data['title'] }}</h5>
                            @include('message/errors')

                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <a href="{{ route('user.queue.create') }}">
                                        <button class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i>
                                            Add</button>
                                    </a>
                                    <a href="{{ route('user.queue.export') }}">
                                        <button class="btn btn-outline-success"><i class="ri ri-file-excel-2-line"></i>
                                            Excel Export</button>
                                    </a>
                                </div>

                            </div>



                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Complaint</th>
                                            <th scope="col">Reporter</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Report Time</th>
                                            <th scope="col">Report Date</th>
                                            <th scope="col">Actions</th>
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
                                                    <div class="badge bg-danger">Queue</div>
                                                </td>
                                                <td>{{ $complaint->complaint_time }}</td>
                                                <td>{{ $complaint->complaint_date }}</td>
                                                <td>
                                                    <a href="{{ route('user.queue.show', $complaint->complaint_id) }}">
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


    </main><!-- End #main -->

    <script>
        // Saat dokumen siap
        $(document).ready(function() {

            $('.show-alert-process-box').on('click', function(e) {
                // Mencegah tindakan default dari tautan
                e.preventDefault();

                // Menampilkan konfirmasi SweetAlert2
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to process the complaint.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, process it!'
                }).then((result) => {
                    // Jika pengguna mengonfirmasi
                    if (result.isConfirmed) {
                        // Lanjutkan ke halaman yang ditentukan
                        window.location.href = $(this).closest('a').attr('href');

                    }
                });
            });

            $('.show-alert-delete-box').on('click', function() {
                var form = $(this).closest("form");

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this item!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endsection
