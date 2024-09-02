@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header text-uppercase">
                Tambah transaksi {{ request()->query('type') == 'in' ? 'masuk' : 'keluar' }}
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
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>{{ session('success') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form id="liquidsForm" action="{{ route('waste.store', request()->query()) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="date" class="form-label">Tipe Transaksi</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select bg-secondary-subtle" id="type" name="type" required disabled>
                                <option disabled {{ old('type') ? '' : 'selected' }}>Pilih Tipe</option>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="codeName" class="form-label">Kode</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control bg-secondary-subtle" id="codeName" name="code_name"
                                   placeholder="Kode" required value="{{ $codeName }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="list_waste"
                                   class="col-form-label">Limbah {{ request()->query('waste') == 'b3' ? 'B3' : 'Cairan' }}</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select select2" id="list_waste" name="list_waste_id"
                                    data-placeholder="Pilih Limbah {{ request()->query('waste') == 'b3' ? 'B3' : 'Cairan' }}"
                                    required>
                                <option></option>
                                @foreach($lists as $list)
                                    <option
                                        value="{{ $list['id'] }}" {{ old('list_waste_id') == $list['id'] ? 'selected' : '' }}>
                                        {{ $list['text'] }}
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
                            <label for="quantity" class="form-label">Jumlah</label>
                        </div>
                        <div class="col-md-2">
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
                    @if(request('waste') === 'b3' && request('type') === 'out')
                        <div class="mb-3 row">
                            <div class="col-md-2">
                                <label for="shipper_name" class="form-label required">Nama Pengangkut</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="shipper_name" name="shipper_name"
                                       placeholder="Nama Pengangkut" required value="{{ old('shipper_name') }}">
                            </div>
                        </div>
                    @endif
                    <input type="hidden" name="status" value="approved">
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
                            <a href="{{ back()->getTargetUrl() }}" class="btn btn-secondary mx-1">Batal</a>
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
            const liquidWaste = $('#list_waste')
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
                    url: '{{ route('waste.getUnitByLiquid', ($lists[0]['id'] ?? 0)) }}'.replace('{{ ($lists[0]['id'] ?? 0 ) }}', liquidWasteId),
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
