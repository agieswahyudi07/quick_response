@extends('admin/layout/layout')\

@section('main')
    <div id="main" class="main">

        <div class="pagetitle">
            <h1>Add {{ $data['title'] }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                            <form id="formCompleted" name="formCompleted" class="row g-3" method="POST"
                                action="{{ route('admin.progress.completed.store') }}">
                                @csrf


                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Complaint</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" aria-label="Default select example" id="selComplaint"
                                            name="selComplaint">
                                            @if (session()->has('selComplaint'))
                                                @php
                                                    $selComplaint = session('selComplaint');
                                                @endphp
                                                <option value="{{ $selComplaint }}" selected>
                                                    {{ $selComplaint }}
                                                </option>
                                            @else
                                                <option value="" selected disabled>Select Complaint</option>
                                            @endif
                                            @foreach ($data['complaints'] as $complaint)
                                                <option value="{{ $complaint->complaint_id }}"
                                                    {{ $complaint->complaint_id == $data['complaint_id'] ? 'selected' : '' }}>
                                                    {{ $complaint->priority->priority_name . ' - ' . $complaint->complaint_name . '|' . $complaint->complaint_reporter }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <label for="txtTroubleCause" class="col-sm-2 col-form-label">Trouble Cause</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txtTroubleCause"
                                            name="txtTroubleCause" value="{{ Session::get('txtTroubleCause') }}">
                                        <div class="invalid-feedback"></div>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="txtTroubleSolution" class="col-sm-2 col-form-label">Trouble Solution</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txtTroubleSolution"
                                            name="txtTroubleSolution" value="{{ Session::get('txtTroubleSolution') }}">
                                        <div class="invalid-feedback"></div>

                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="submitCompleted"
                                            name="submitCompleted">Submit Form</button>
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

            $('#formCompleted').validate({
                rules: {
                    selComplaint: {
                        required: true,
                    },
                    txtTroubleCause: {
                        required: true,
                    },
                    txtTroubleSolution: {
                        required: true,
                    },
                },
                messages: {
                    selComplaint: {
                        required: "Please select complaint.",
                    },
                    txtTroubleCause: {
                        required: "Please enter trouble cause.",
                    },
                    txtTroubleSolution: {
                        required: "Please enter the solution.",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    element.next('.invalid-feedback').html(error.html());
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid')
                },
                submitHandler: function(form) {
                    $('#submitCompleted').prop('disabled', true).val('Processing...');
                    form.submit();
                }
            });

        });
    </script>
@endsection
