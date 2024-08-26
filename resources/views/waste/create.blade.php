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
                <form id="liquidsForm" action="{{ route('waste.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-2">
                            <label for="liquid_waste" class="col-form-label">Cairan limbah</label>
                        </div>
                        <div class="col-3">
                            <select class="form-select select2" id="liquid_waste" name="liquid_waste"
                                    data-placeholder="Pilih Cairan Limbah" required>
                                <option></option>
                                @foreach($liquids as $liquid)
                                    <option value="{{ $liquid['id'] }}">{{ $liquid['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <label for="unit" class="col-form-label">Satuan</label>
                        </div>
                        <div class="col-2">
                            <select class="form-select select2" id="unit" name="unit"
                                    data-placeholder="Pilih Satuan" required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="codeName" class="form-label">Kode</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="codeName" name="codeName"
                                   placeholder="Kode" required value="{{ $codeName ?? '' }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="quantity" class="form-label">Jumlah</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="quantity" name="quantity"
                                   placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-8">
                            <small class="text-muted" id="quantityInfo">* dalam satuan</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="photo" class="form-label">Foto</label>
                        </div>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">* Foto harus berformat JPG, JPEG, PNG, atau BMP</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="description" class="form-label">Deskripsi</label>
                        </div>
                        <div class="col-md-6">
                            <textarea class="form-control" id="description" rows="3" name="description"
                                      placeholder="Deskripsi" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                            <a href="{{ route('waste.index') }}" class="btn btn-secondary">Kembali</a>
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

            // load unit from ajax when liquid waste selected
            liquidWaste.on('select2:select', function (e) {
                const selectedLiquidWaste = e.params.data
                $.ajax({
                    url: '{{ config('app.url') }}waste/liquid/' + selectedLiquidWaste.id + '/units',
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
                    }
                })
            })

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
        })

        function changeUnitInfo(symbol) {
            $('#quantityInfo').text(`* dalam satuan ${symbol}`)
        }
    </script>
@endpush
