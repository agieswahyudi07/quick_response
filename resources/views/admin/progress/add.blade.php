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
                        <form class="row g-3" method="POST" action="{{ route('admin.progress.hold.store') }}">
                            @csrf


                            {{-- coba complaint id --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Complaint</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="selComplaint" name="selComplaint">
                                        @if (session()->has('txtComplaint'))
                                            <option value="{{ Session::get('selComplaint') }}">
                                                {{ Session::get('txtComplaint') }}</option>
                                        @else
                                            <option value="" selected disabled>Select Complaint</option>
                                        @endif
                                        @foreach ($data['complaints'] as $complaint)
                                            @php
                                                $selected = '';
                                                // Cek apakah 'id' dari controller ada
                                                if (isset($data['complaint_id']) && $data['complaint_id'] == $complaint->complaint_id) {
                                                    $selected = 'selected';
                                                }
                                            @endphp
                                            <option value="{{ $complaint->complaint_id }}" {{ $selected }}>
                                                {{ $complaint->priority->priority_name .' - '. $complaint->complaint_name . '|' . $complaint->complaint_reporter }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            

                            <div class="row mb-3">
                            <label for="txtNeedName" class="col-sm-2 col-form-label">Item Need</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtNeedName" name="txtNeedName" value="{{ Session::get('txtNeedName') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtNeedQty" class="col-sm-2 col-form-label">Item Quantity</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtNeedQty" name="txtNeedQty" value="{{ Session::get('txtNeedQty') }}">
                            </div>
                            </div>
                    
                            <div class="row mb-3">
                            <label for="txtNeedPrice" class="col-sm-2 col-form-label">Item Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtNeedPrice" name="txtNeedPrice" value="{{ Session::get('txtNeedPrice') }}">
                            </div>
                            </div>

                            <div class="row mb-3">
                            <label for="txtNeedDetail" class="col-sm-2 col-form-label">Item Detail</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px" id="txtNeedDetail" name="txtNeedDetail">{{ Session::get('txtNeedDetail') }}</textarea>
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

        // Fungsi untuk format angka menjadi format uang
        function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function updatePriceInput(input) {
                let value = input.value.replace(/[^\d.]/g, '');
                value = value.replace(/(\..*)\./g, '$1');

                let number = parseFloat(value);

                if (!isNaN(number)) {
                    let formattedNumber = formatNumber(number);
                    input.value = formattedNumber;
                } else {
                    input.value = '';
                }
            }

            // Panggil fungsi updatePriceInput saat input harga diisi
            $('#txtNeedPrice').on('input', function() {
                updatePriceInput(this);
            });

            // Panggil fungsi updatePriceInput saat input harga diisi
            $('#txtNeedQty').on('input', function() {
                updatePriceInput(this);
            });


    });
</script>

@endsection