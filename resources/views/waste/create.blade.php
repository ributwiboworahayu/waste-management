@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                Tambah transaksi
            </div>
            <div class="card-body">
                @if($error ?? false)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p>{!! $error !!}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Whoops!</strong> Terdapat kesalahan saat menyimpan data:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form id="liquidsForm" action="{{ route('waste.store', request()->query()) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="liquid_waste" class="col-form-label">Cairan limbah</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select select2" id="liquid_waste" name="liquid_waste_id"
                                    data-placeholder="Pilih Cairan Limbah" required>
                                <option></option>
                                @foreach($liquids as $liquid)
                                    <option
                                        value="{{ $liquid['id'] }}" {{ old('liquid_waste_id') == $liquid['id'] ? 'selected' : '' }}>
                                        {{ $liquid['text'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="unit" class="col-form-label">Satuan</label>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select select2" id="unit" name="unit_id"
                                    data-placeholder="Pilih Satuan" required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="codeName" class="form-label">Kode</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="codeName" name="code_name"
                                   placeholder="Kode" required value="{{ $codeName ?? '' }}">
                        </div>
                        <div class="col-md-1">
                            <label for="date" class="form-label">Tipe</label>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="type" name="type" required>
                                <option disabled {{ old('type') ? '' : 'selected' }}>Pilih Tipe</option>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="quantity" class="form-label">Jumlah</label>
                        </div>
                        <div class="col-md-1">
                            <input type="text" class="form-control" id="quantity" name="quantity"
                                   placeholder="Jumlah" required value="{{ old('quantity') }}">
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted" id="quantityInfo">*</small>
                        </div>
                        <div class="col-md-1">
                            <label for="available_quantity" class="form-label">Stok</label>
                        </div>
                        <div class="col-md-1">
                            <input type="text" class="form-control text-info" value="0" readonly
                                   id="available_quantity">
                        </div>
                        <div class="col-sm-2">
                            <small class="text-muted" id="quantityNow">*</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="photo" class="form-label">Foto</label>
                        </div>
                        <div class="col-md-4">
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*"
                                   value="{{ old('photo') }}">
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">* Foto harus berformat JPG, JPEG, PNG, atau
                                BMP</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="document" class="form-label">Dokumen</label>
                        </div>
                        <div class="col-md-4">
                            <input type="file" class="form-control" id="document" name="document" accept="image/*"
                                   value="{{ old('document') }}">
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">* Lampiran Foto Dokumen</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="input_by" class="form-label">Input Oleh</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="input_by" name="input_by"
                                   placeholder="Di input Oleh" required value="{{ old('input_by') }}">
                        </div>
                        <div class="col-md-1">
                            <label for="date" class="form-label">Tanggal</label>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="input_at" name="input_at"
                                   placeholder="Tanggal" required value="{{ old('date') ?? date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="shipper_name" class="form-label required">Nama Pengangkut</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="shipper_name" name="shipper_name"
                                   placeholder="Nama Pengangkut" required value="{{ old('shipper_name') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option
                                    value="approved" {{ old('status') == 'approved' || !old('status') ? 'selected' : '' }}>
                                    Accepted
                                </option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="description" class="form-label">Deskripsi</label>
                        </div>
                        <div class="col-md-6">
                            <textarea class="form-control" id="description" rows="3" name="description"
                                      placeholder="Deskripsi"
                                      required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                            <a href="{{ route('waste.index', request()->query()) }}" class="btn btn-secondary mx-1">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            const liquidWaste = $('#liquid_waste')
            const unit = $('#unit')

            // select a type from query param
            const type = new URLSearchParams(window.location.search).get('type')
            if (type) $('#type').val(type).trigger('change')
            

            // load unit from ajax when liquid waste selected
            liquidWaste.on('select2:select', function (e) {
                const selectedLiquidWaste = e.params.data
                updateUnitData(selectedLiquidWaste.id)
            })

            if (liquidWaste.val()) updateUnitData(liquidWaste.val())

            unit.on('select2:select', function (e) {
                const selectedUnit = e.params.data
                changeUnitInfo(selectedUnit.symbol)
            })

            $('#liquidsForm').on('input', 'input[id^=codeName]', function () {
                this.value = this.value.toUpperCase()
            })

            $('#quantity').on('keypress', function (e) {
                return e.metaKey || (e.charCode >= 48 && e.charCode <= 57) || e.charCode === 46
            })

            function updateUnitData(liquidWasteId) {
                $.ajax({
                    url: '{{ config('app.url') }}waste/liquid/' + liquidWasteId + '/units',
                    type: 'GET',
                    success: function (response) {
                        unit.empty()
                        unit.append('<option></option>')
                        unit.select2({
                            data: response.data,
                            theme: 'bootstrap-5',
                            placeholder: 'Pilih Satuan',
                            width: '100%' // Make sure the Select2 dropdown is full width
                        })

                        if (response.data.length > 0) {
                            unit.val(response.data[0].id).trigger('change')
                        }

                        // change unit info
                        changeUnitInfo(response.data[0].symbol)

                        $('#quantityNow').text(`* dalam satuan ${response.data[0].symbol}`)
                        $('#available_quantity').val(response.data[0].quantity)
                    }
                })
            }
        })

        function changeUnitInfo(symbol) {
            $('#quantityInfo').text(`* dalam satuan ${symbol}`)
        }
    </script>
@endpush
