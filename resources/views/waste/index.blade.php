@extends('layouts.app')

@section('title', 'Units')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                Cairan
            </div>
            <div class="card-body">
                @if($error ?? false)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <span>{!! $error !!}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @else
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('waste.create') }}" class="btn btn-primary" id="createNewWaste">Buat Baru</a>
                    </div>
                @endif
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
                        <label for="type" class="col-sm-1 col-form-label">Tipe</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" id="type" readonly>
                        </div>
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
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'code', name: 'code'},
                    {data: 'type', name: 'type'},
                    {data: 'liquid_name', name: 'liquid_name'},
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
                    if (page) {
                        wasteTable.DataTable().page(page - 1).draw('page')
                    }
                    // set add + page
                    const pageInfo = wasteTable.DataTable().page.info()
                    page = pageInfo.page + 1
                    $('#createNewWaste').attr('href', `{{ route('waste.create') }}?page=${page}`)
                    window.history.replaceState(null, null, `?page=${page}`)
                }
            })

            wasteTable.on('page.dt', function () {
                // get current page
                const info = wasteTable.DataTable().page.info()
                const page = info.page + 1

                // set url
                window.history.replaceState(null, null, `?page=${page}`)

                // set add + page
                $('#createNewWaste').attr('href', `{{ route('waste.create') }}?page=${page}`)
            })

            wasteTable.on('click', '.btn-detail', function (e) {
                e.preventDefault()
                const url = $(this).attr('href')
                $.get(url, function (response) {
                    $('#showModal .modal-title').text(`${response.data.code}`)
                    $('#showModal').modal('show')
                })
            })
        })
    </script>
@endpush
