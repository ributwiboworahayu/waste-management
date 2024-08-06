@extends('layouts.app')

@section('title', 'Units')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Cairan
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('waste.liquid.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editModalBody">
                        <div class="mb-3">
                            <label for="editCode" class="form-label">Kode</label>
                            <input type="text" class="form-control" name="code" id="editCode" required>
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUnit" class="form-label">Satuan</label>
                            <select name="unit" id="editUnit" class="form-select" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Kuantitas</label>
                            <input type="number" class="form-control" name="quantity" id="editQuantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
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
                                buttons += `<a href="${value.route}" class="btn btn-sm ${value.class}">`
                                    + `<i class="${value.icon}"></i> `
                                    + `</a> `
                            })
                            return buttons
                        }
                    }
                ]
            })

            liquidTable.on('click', '.btn-delete', function (e) {
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
                                    $('#unitsTable').DataTable().ajax.reload()
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
            liquidTable.on('click', '.btn-edit', function (e) {
                e.preventDefault()

                // show modal
                $('#editModal').modal('show')
                // show the data from table
                const data = $('#liquidTable').DataTable().row($(this).parents('tr')).data()
                const url = $(this).attr('href')

                $('#editModal form').attr('action', url)
                $('#editCode').val(data.code)
                $('#editName').val(data.name)
                $('#editQuantity').val(data.quantity)
                $('#editDescription').val(data.description)

                // Set selected unit in modal
                const unitSelect = $('#editUnit')
                const unitOptions = unitSelect.find('option')

                // Find the option with text matching the data.unit
                unitOptions.each(function () {
                    if ($(this).text() === data.unit) {
                        unitSelect.val($(this).val()).trigger('change')
                        return false // Exit the loop once the match is found
                    }
                })
            })
        })
    </script>
@endpush
