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
                        <li>{!! $error !!}</li>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @else
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('waste.create') }}" class="btn btn-primary">Tambah</a>
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
                    <table id="liquidTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Kuantitas</th>
                            <th>Deskripsi</th>
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
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            const liquidTable = $('#liquidTable')
            liquidTable.DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset('assets/lang/id/dataTables.json') }}'
                },
                ajax: {
                    url: '{{ route('waste.liquid.datatables') }}',
                    data: function (d) {
                        d.order[0].column--
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'unit', name: 'unit'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'description', name: 'description'},
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
                ]
            })
        })
    </script>
@endpush
