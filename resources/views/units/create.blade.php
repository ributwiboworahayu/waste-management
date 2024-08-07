@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Tambah Satuan
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
                <form id="unitsForm" action="{{ route('waste.units.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div id="unitsContainer">
                        @if (old('units'))
                            @foreach (old('units') as $index => $unit)
                                <div class="unit-group row mb-3" data-index="{{ $index }}">
                                    <div class="col-md-4">
                                        <label for="name_{{ $index }}" class="form-label">Nama Satuan</label>
                                        <input type="text" class="form-control" id="name_{{ $index }}"
                                               name="units[{{ $index }}][name]" value="{{ $unit['name'] }}" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="description_{{ $index }}" class="form-label">Deskripsi</label>
                                        <input type="text" class="form-control" id="description_{{ $index }}"
                                               name="units[{{ $index }}][description]"
                                               value="{{ $unit['description'] }}">
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <div class="unit-group row mb-3" data-index="0">
                                <div class="col-md-4">
                                    <label for="name_0" class="form-label">Nama Satuan</label>
                                    <input type="text" class="form-control" id="name_0" name="units[0][name]"
                                           required>
                                </div>
                                <div class="col-md-8">
                                    <label for="description_0" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="description_0"
                                           name="units[0][description]">
                                </div>
                            </div>
                            <hr>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button type="button" id="addUnitButton" class="btn btn-secondary">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button type="button" id="removeUnitButton" class="btn btn-danger mx-1">
                                <i class="bi bi-dash"></i>
                            </button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                            <a href="{{ route('waste.units') }}" class="btn btn-secondary">Kembali</a>
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
            let unitIndex = $('#unitsContainer .unit-group').length

            $('#addUnitButton').click(function () {
                const newUnitGroup = `
                    <div class="unit-group row mb-3" data-index="${unitIndex}">
                        <div class="col-md-4">
                            <label for="name_${unitIndex}" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" id="name_${unitIndex}" name="units[${unitIndex}][name]" required>
                        </div>
                        <div class="col-md-8">
                            <label for="description_${unitIndex}" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="description_${unitIndex}" name="units[${unitIndex}][description]" required>
                        </div>
                    </div>
                    <hr>
                `

                $('#unitsContainer').append(newUnitGroup)
                $('#removeUnitButton').prop('disabled', false).removeClass('disabled')
                unitIndex++
            })

            $('#removeUnitButton').click(function () {
                if ($('#unitsContainer .unit-group').length > 1) {
                    $('#unitsContainer .unit-group').last().remove()
                    $('#unitsContainer hr').last().remove()
                    unitIndex--
                }
            })

            if ($('#unitsContainer .unit-group').length === 1) {
                $('#removeUnitButton').prop('disabled', true).addClass('disabled')
            }

        })
    </script>
@endpush
