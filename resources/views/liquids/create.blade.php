@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Tambah Cairan
            </div>
            <div class="card-body">
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
                <form id="liquidsForm" action="{{ route('waste.liquid.store') }}" method="POST">
                    @csrf
                    <div id="liquidsContainer">
                        @if (old('liquids'))
                            @foreach (old('liquids') as $index => $liquid)
                                <div class="liquid-group row mb-3" data-index="{{ $index }}">
                                    <div class="col-auto">
                                        <label for="codeName_{{ $index }}" class="form-label">Kode</label>
                                        <input type="text" class="form-control" id="codeName_{{ $index }}"
                                               name="liquids[{{ $index }}][codeName]" value="{{ $liquid['codeName'] }}"
                                               placeholder="K01.." required>
                                    </div>
                                    <div class="col-auto">
                                        <label for="name_{{ $index }}" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name_{{ $index }}"
                                               name="liquids[{{ $index }}][name]" value="{{ $liquid['name'] }}"
                                               placeholder="Nama" required>
                                    </div>
                                    <div class="col-auto">
                                        <label for="unitName_{{ $index }}" class="form-label">Satuan</label>
                                        <select class="form-select select2" id="unitName_{{ $index }}"
                                                name="liquids[{{ $index }}][unitName]" data-placeholder="Pilih Satuan"
                                                required>
                                            <option></option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ $unit->id == $liquid['unitName'] ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="description_{{ $index }}" class="form-label">Deskripsi</label>
                                        <input type="text" class="form-control" id="description_{{ $index }}"
                                               name="liquids[{{ $index }}][description]"
                                               value="{{ $liquid['description'] }}"
                                               placeholder="Deskripsi">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="liquid-group row mb-3">
                                <div class="col-auto">
                                    <label for="codeName_0" class="form-label">Kode</label>
                                    <input type="text" class="form-control" id="codeName_0" name="liquids[0][codeName]"
                                           placeholder="K01.." required>
                                </div>
                                <div class="col-auto">
                                    <label for="name_0" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name_0" name="liquids[0][name]"
                                           placeholder="Nama"
                                           required>
                                </div>
                                <div class="col-auto">
                                    <label for="unitName_0" class="form-label">Satuan</label>
                                    <select class="form-select select2" id="unitName_0" name="liquids[0][unitName]"
                                            data-placeholder="Pilih Satuan" required>
                                        <option></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="description_0" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="description_0"
                                           name="liquids[0][description]"
                                           placeholder="Deskripsi">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button type="button" id="addLiquidButton" class="btn btn-secondary">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button type="button" id="removeLiquidButton" class="btn mx-1 btn-danger" disabled>
                                <i class="bi bi-dash"></i>
                            </button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                            <a href="{{ route('waste.liquid') }}" class="btn btn-secondary">Kembali</a>
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

            $('#removeLiquidButton').on('click', function () {
                if ($('#liquidsContainer .liquid-group').length > 1) {
                    $('#liquidsContainer .liquid-group').last().remove()
                    if ($('#liquidsContainer .liquid-group').length === 1) {
                        $('#removeLiquidButton').prop('disabled', true)
                    }
                    liquidIndex--
                }
            })

            $('#removeLiquidButton').attr('disabled', true)
        })
    </script>
@endpush
