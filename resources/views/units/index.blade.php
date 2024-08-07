@extends('layouts.app')

@section('title', 'Units')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                Satuan
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('waste.units.create') }}" id="addUnitButton" class="btn btn-primary">Tambah
                        Satuan</a>
                </div>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </ul>
                    </div>
                @endif
                <table id="unitsTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Satuan</th>
                        <th>Simbol</th>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editModalBody">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Satuan</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="symbol" class="form-label">Simbol</label>
                            <input type="text" class="form-control" name="symbol" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            const unitsTable = $('#unitsTable')

            unitsTable.DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset('assets/lang/id/dataTables.json') }}'
                },
                ajax: {
                    url: '{{ route('waste.units.datatables') }}',
                    data: function (d) {
                        d.order[0].column--
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'symbol', name: 'symbol'},
                    {data: 'description', name: 'description'},
                    {
                        data: 'actions', name: 'action', orderable: false, searchable: false,
                        render: function (data) {
                            let buttons = ''
                            $.each(data, function (key, value) {
                                buttons += `<a href="${value.route}" class="btn btn-sm mx-sm-1 ${value.class}"><i class="${value.icon}"></i></a> `
                            })
                            return buttons
                        }
                    }
                ],
                initComplete: function () {
                    unitsTable.wrap('<div class="table-responsive"></div>')

                    // get page from url
                    const urlParams = new URLSearchParams(window.location.search)
                    const page = urlParams.get('page')
                    if (page) {
                        unitsTable.DataTable().page(page - 1).draw('page')

                        // set button add + page
                        $('#addUnitButton').attr('href', '{{ route('waste.units.create') }}?page=' + page)
                    }
                }
            })

            // on click first, previous, next, and last page
            // when clicked, change the url
            unitsTable.on('page.dt', function () {
                const pageInfo = unitsTable.DataTable().page.info()
                window.history.replaceState(null, null, `?page=${pageInfo.page + 1}`)

                // set button add + page
                $('#addUnitButton').attr('href', '{{ route('waste.units.create') }}?page=' + (pageInfo.page + 1))
            })

            unitsTable.on('click', '.btn-delete', function (e) {
                e.preventDefault()
                const url = $(this).attr('href')
                const token = '{{ csrf_token() }}'

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                '_method': 'DELETE',
                                '_token': token
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    // reload ajax and reset page to now page
                                    const pageInfo = unitsTable.DataTable().page.info()
                                    $('#unitsTable').DataTable().ajax.reload().page(pageInfo.page).draw('page')
                                })
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: xhr.responseJSON.message,
                                    icon: 'error'
                                })
                            }
                        })
                    }
                })
            })

            // edit show modal
            unitsTable.on('click', '.btn-edit', function (e) {
                e.preventDefault()

                // show modal
                $('#editModal').modal('show')
                // show the data from table
                const data = unitsTable.DataTable().row($(this).parents('tr')).data()
                const url = $(this).attr('href')

                const page = unitsTable.DataTable().page.info().page + 1
                $('#editModal form').attr('action', `${url}?page=${page}`)
                $('#editModal form input[name="name"]').val(data.name).attr('readonly', true)
                $('#editModal form input[name="symbol"]').val(data.symbol).attr('readonly', true)
                $('#editModal form textarea[name="description"]').val(data.description)
            })
        })
    </script>
@endpush
