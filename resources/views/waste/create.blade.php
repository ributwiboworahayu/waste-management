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
                        <li>{!! $error !!}</li>
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
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="liquid_waste" class="col-form-label">Cairan limbah</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-select select2" id="liquid_waste" name="liquid_waste"
                                    data-placeholder="Pilih Cairan Limbah" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="unit" class="col-form-label">Satuan</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-select select2" id="unit" name="unit"
                                    data-placeholder="Pilih Satuan" required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row mt-2">
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
            let liquidIndex = $('#liquidsContainer .liquid-group').length
            const unitOptions = @json($units)

            $('#addLiquidButton').on('click', function () {
                const liquidGroup = `
                    <div class="liquid-group row mb-3" data-index="${liquidIndex}">
                        <div class="col-auto">
                            <label for="codeName_${liquidIndex}" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="codeName_${liquidIndex}" name="liquids[${liquidIndex}][codeName]"
                                   placeholder="K0${liquidIndex + 1}.." required>
                        </div>
                        <div class="col-auto">
                            <label for="name_${liquidIndex}" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name_${liquidIndex}" name="liquids[${liquidIndex}][name]"
                                   placeholder="Nama" required>
                        </div>
                        <div class="col-auto">
                            <label for="unitName_${liquidIndex}" class="form-label">Satuan</label>
                            <select class="form-select select2" id="unitName_${liquidIndex}" name="liquids[${liquidIndex}][unitName]"
                                    data-placeholder="Pilih Satuan" required>
                                <option></option>
                                ${unitOptions.map(unit => `<option value="${unit.id}">${unit.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="description_${liquidIndex}" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="description_${liquidIndex}" name="liquids[${liquidIndex}][description]"
                                   placeholder="Deskripsi">
                        </div>
                    </div>
                `

                $('#liquidsContainer').append(liquidGroup)
                $('#removeLiquidButton').prop('disabled', false)

                // Initialize Select2 for new elements
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Pilih Satuan',
                    width: '100%' // Make sure the Select2 dropdown is full width
                })

                liquidIndex++
            })


            const removeLiquidButton = $('#removeLiquidButton')
            removeLiquidButton.on('click', function () {
                const liquidGroup = $('#liquidsContainer .liquid-group')
                if (liquidGroup.length > 1) {
                    liquidGroup.last().remove()
                    if (liquidGroup.length <= 2) {
                        $('#removeLiquidButton').prop('disabled', true)
                    }
                    liquidIndex--
                }
            })

            removeLiquidButton.attr('disabled', true)

            // auto capitalize codeName
            $('#liquidsForm').on('input', 'input[id^=codeName]', function () {
                this.value = this.value.toUpperCase()
            })
        })
    </script>
@endpush
