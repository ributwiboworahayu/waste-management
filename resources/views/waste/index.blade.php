@extends('layouts.app')

@section('title', 'Transaksi Limbah')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="card-title">Transaksi Limbah</h5>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="dropdown ms-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="newTransaction"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Tambah Transaksi
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="newTransaction">
                                <li><a class="dropdown-item"
                                       href="{{ route('waste.create', array_merge(request()->query(), ['type' => 'in'])) }}">Masuk</a>
                                <li><a class="dropdown-item"
                                       href="{{ route('waste.create', array_merge(request()->query(), ['type' => 'out'])) }}">Keluar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any() || session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <li>{{ session('error') }}</li>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </ul>
                    </div>
                @endif
                <div class="mb-3 container-fluid">
                    <form action="{{ route('waste.index') }}" method="get">
                        <div class="row mb-2">
                            <div class="col-sm-2">
                                <label for="type" class="col-form-label">Tipe Transaksi</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <select name="type" id="type" class="form-select">
                                        <option value="">Semua</option>
                                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk
                                        </option>
                                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="waste" class="col-form-label">Jenis Limbah</label>
                            </div>
                            <div class="col-sm-3">
                                <select name="waste" id="waste_type" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="b3" {{ request('waste') == 'b3' ? 'selected' : '' }}>B3
                                    </option>
                                    <option
                                        value="liquid" {{ request('waste') == 'liquid' ? 'selected' : '' }}>
                                        Cairan
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table id="wasteTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Tipe</th>
                            <th>Nama Cairan</th>
                            <th>Kuantitas</th>
                            <th>Satuan</th>
                            <th>Disetujui Oleh</th>
                            <th>Tanggal Disetujui</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Data rows will go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="code" class="col-sm-1 col-form-label">Kode</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="code" readonly>
                        </div>
                        <label for="type" class="col-sm-1 col-form-label">Jenis Limbah</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" id="type" readonly>
                        </div>
                        <label for="transaction_date" class="col-sm-2 col-form-label">Tgl.Transaksi</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="transaction_date" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="list_name" class="col-sm-2 col-form-label">Nama Cairan</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="list_name" readonly>
                        </div>
                        <label for="quantity" class="col-sm-2 col-form-label">Kuantitas</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="quantity" readonly>
                        </div>
                        <label for="unit" class="col-sm-1 col-form-label">Satuan</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="unit" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input_by" class="col-sm-2 col-form-label">Diinput Oleh</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="input_by" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="shipper_name" class="col-sm-2 col-form-label">Diangkut Oleh</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="shipper_name" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Kolom kiri -->
                        <div class="col-sm-6">
                            <label for="photos" class="form-label d-block">Foto</label>
                            <img src="#" alt="Foto" id="photos" class="img-thumbnail mt-2"
                                 style="max-width: 200px; max-height: 200px;">
                        </div>
                        <!-- Kolom kanan -->
                        <div class="col-sm-6">
                            <label for="document" class="form-label d-block">Dokumen</label>
                            <img src="#" alt="Dokumen" id="document" class="img-thumbnail mt-2"
                                 style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @push('custom-js')
            <script>
                $(document).ready(function () {
                    const wasteTable = $('#wasteTable')
                    wasteTable.DataTable({
                        processing: true,
                        serverSide: true,
                        language: {
                            url: '{{ asset('assets/lang/id/dataTables.json') }}'
                        },
                        ajax: {
                            url: '{{ route('waste.datatables') }}',
                            data: function (d) {
                                d.order[0].column--
                                d.type = '{{ request('type') }}'
                                d.waste = '{{ request('waste') }}'
                            }
                        },
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                            {data: 'code', name: 'code'},
                            {data: 'type', name: 'type'},
                            {data: 'list_name', name: 'list_name'},
                            {data: 'quantity', name: 'quantity'},
                            {data: 'unit', name: 'unit'},
                            {data: 'approved_by', name: 'approved_by'},
                            {data: 'approved_date', name: 'approved_date'},
                            {
                                data: 'actions', name: 'actions', orderable: false, searchable: false,
                                render: function (data) {
                                    let buttons = ''
                                    $.each(data, function (key, value) {
                                        buttons += `<a href="${value.route}" class="btn btn-sm mx-sm-1 ${value.class}"><i class="${value.icon}"></i></a>  `
                                    })
                                    return buttons
                                }
                            }
                        ],
                        initComplete: function () {
                            // get page from url
                            const urlParams = new URLSearchParams(window.location.search)
                            let page = urlParams.get('page')
                            const createNewWaste = $('#createNewWaste')
                            if (page) {
                                wasteTable.DataTable().page(page - 1).draw('page')
                            }
                            // set add + page
                            const pageInfo = wasteTable.DataTable().page.info()
                            page = pageInfo.page + 1

                            urlParams.set('page', page)
                            const urlParamsString = urlParams.toString()
                            createNewWaste.attr('href', `{{ route('waste.create') }}?${urlParamsString}`)
                            // set url
                            window.history.replaceState(null, null, `?${urlParamsString}`)
                        }
                    })

                    wasteTable.on('page.dt', function () {
                        // get current page
                        const info = wasteTable.DataTable().page.info()
                        const page = info.page + 1
                        const urlParams = new URLSearchParams(window.location.search)
                        urlParams.set('page', page)
                        const urlParamsString = urlParams.toString()

                        // set url
                        window.history.replaceState(null, null, `?${urlParamsString}`)

                        // set add + page
                        $('#createNewWaste').attr('href', `{{ route('waste.create') }}?${urlParamsString}`)
                    })

                    wasteTable.on('click', '.btn-detail', function (e) {
                        e.preventDefault()
                        const url = $(this).attr('href')
                        $.get(url, function (response) {
                            $('#showModal .modal-title').text(`Transaksi ${response.data.code}`)
                            $('#showModal #code').val(response.data.code)
                            $('#showModal #type').val(response.data.type)
                            $('#showModal #transaction_date').val(response.data.approved_at)
                            $('#showModal #list_name').val(response.data.detail.list_waste.name)
                            $('#showModal #quantity').val(response.data.detail.quantity)
                            $('#showModal #unit').val(response.data.detail.unit.name)
                            $('#showModal #input_by').val(response.data.detail.input_by)
                            $('#showModal #shipper_name').val(response.data.detail.shipper_name)
                            $('#showModal #photos').attr('src', response.data.detail.photo)
                            $('#showModal #document').attr('src', response.data.detail.document)
                            $('#showModal #description').val(response.data.detail.description)
                            $('#showModal').modal('show')
                        })
                    })
                })
            </script>
    @endpush
