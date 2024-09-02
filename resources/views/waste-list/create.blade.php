@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                Tambah {{ request()->query('waste') === 'b3' ? 'Bahan Berbahaya dan Beracun (B3)' : 'Limbah Cair' }}
            </div>
            <div class="card-body">
                @if($error)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <span>{!! $error !!}</span>
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
                <form id="listsForm" action="{{ route('waste.list.store', request()->query()) }}" method="post">
                    @csrf
                    <div id="listsContainer">
                        @if (old('lists'))
                            @foreach (old('lists') as $index => $liquid)
                                <div class="liquid-group row mb-3" data-index="{{ $index }}">
                                    <div class="col-md-2">
                                        <label for="codeName_{{ $index }}" class="form-label">Kode</label>
                                        <input type="text" class="form-control bg-secondary-subtle"
                                               id="codeName_{{ $index }}"
                                               name="lists[{{ $index }}][codeName]" value="{{ $liquid['codeName'] }}"
                                               placeholder="K01.." required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name_{{ $index }}" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name_{{ $index }}"
                                               name="lists[{{ $index }}][name]" value="{{ $liquid['name'] }}"
                                               placeholder="Nama" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="unitName_{{ $index }}" class="form-label">Satuan</label>
                                        <select class="form-select select2" id="unitName_{{ $index }}"
                                                name="lists[{{ $index }}][unitName]" data-placeholder="Pilih Satuan"
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
                                               name="lists[{{ $index }}][description]"
                                               value="{{ $liquid['description'] }}"
                                               placeholder="Deskripsi">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="liquid-group row mb-3">
                                <div class="col-md-2">
                                    <label for="codeName_0" class="form-label">Kode</label>
                                    <input type="text" class="form-control bg-secondary-subtle" id="codeName_0"
                                           name="lists[0][codeName]"
                                           placeholder="K01.." required value="{{ $codeName }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="name_0" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name_0" name="lists[0][name]"
                                           placeholder="Nama" autofocus
                                           required>
                                </div>
                                <div class="col-md-2">
                                    <label for="unitName_0" class="form-label">Satuan</label>
                                    <select class="form-select select2" id="unitName_0" name="lists[0][unitName]"
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
                                           name="lists[0][description]"
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
            let liquidIndex = $('#listsContainer .liquid-group').length
            const unitOptions = @json($units);

            $('#addLiquidButton').on('click', function () {
                // prefix code from first val of codeName
                let codeName = $('#listsContainer .liquid-group:first input[id^=codeName]').val()
                const padLength = codeName.length - 2
                const codeNamePrefix = codeName.substring(0, 2)
                // last codenum from last val of codeName eg. LQ001 -> 001
                const codeNum = parseInt(codeName.substring(2))
                // make codename increment eg. LQ001 -> LQ002
                codeName = codeNamePrefix + (codeNum + liquidIndex).toString().padStart(padLength, '0')
                const liquidGroup = `
                    <div class="liquid-group row mb-3" data-index="${liquidIndex}">
                        <div class="col-md-2">
                            <label for="codeName_${liquidIndex}" class="form-label">Kode</label>
                            <input type="text" class="form-control bg-secondary-subtle" id="codeName_${liquidIndex}" name="lists[${liquidIndex}][codeName]"
                                   placeholder="K01.." required value="${codeName}">
                        </div>
                        <div class="col-md-2">
                            <label for="name_${liquidIndex}" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name_${liquidIndex}" name="lists[${liquidIndex}][name]"
                                   placeholder="Nama" required>
                        </div>
                        <div class="col-md-2">
                            <label for="unitName_${liquidIndex}" class="form-label">Satuan</label>
                            <select class="form-select select2" id="unitName_${liquidIndex}" name="lists[${liquidIndex}][unitName]"
                                    data-placeholder="Pilih Satuan" required>
                                <option></option>
                                ${unitOptions.map(unit => `<option value="${unit.id}">${unit.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="description_${liquidIndex}" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="description_${liquidIndex}" name="lists[${liquidIndex}][description]"
                                   placeholder="Deskripsi">
                        </div>
                    </div>
                `

                $('#listsContainer').append(liquidGroup)
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
                const liquidGroup = $('#listsContainer .liquid-group')
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
            $('#listsForm').on('input', 'input[id^=codeName]', function () {
                this.value = this.value.toUpperCase()
            })
        })
    </script>
@endpush
