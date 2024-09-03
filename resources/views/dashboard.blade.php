@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div
                        class="card-header bg-warning-subtle text-danger-emphasis d-flex justify-content-between align-items-center mb-4">
                        <h2 class="font-semibold text-xl leading-tight mb-0">
                            {{ __('Dashboard') }}
                        </h2>
                        <p class="mb-0 text-secondary-emphasis">{{ Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <!-- Limbah B3 -->
                            <div class="col-md-4 mb-5">
                                <div class="card h-100 shadow-sm border-0 rounded-3 bg-light p-3 position-relative">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-droplet-fill fs-3 me-3 text-primary"></i>
                                        <div>
                                            <h4 class="mb-0 text-danger">Limbah Cairan</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="mb-0 text-muted">Transaksi Masuk Harian:</p>
                                        <p class="mb-0 text-danger">{{ $data['dailyTotalLiquidIn'] ?? 0 }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="mb-0 text-muted">Transaksi Keluar Harian:</p>
                                        <p class="mb-0 text-danger">{{ $data['dailyTotalLiquidOut'] ?? 0 }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="mb-0 text-muted">Total Transaksi Harian:</p>
                                        <p class="mb-0 text-danger">{{ $data['dailyTotalLiquid'] ?? 0 }}</p>
                                    </div>
                                    <div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <a href="{{ route('waste.index', array_merge(request()->query(), ['waste' => 'liquid' ])) }}"
                                                   class="btn btn-outline-danger w-100 d-flex justify-content-between align-items-center">
                                                    Kelola Limbah Cairan
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="dropdown w-100">
                                                    <a class="btn btn-danger dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                       href="#" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                                       aria-expanded="false">
                                                        Tambah
                                                    </a>
                                                    <ul class="dropdown-menu w-100"
                                                        aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('waste.create', array_merge(request()->query(), ['waste' => 'liquid', 'type'=>'in' ])) }}">
                                                                Limbah Masuk
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('waste.create', array_merge(request()->query(), ['waste' => 'liquid', 'type'=>'out' ])) }}">
                                                                Limbah Keluar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Limbah B3 Lain -->
                            <div class="col-md-4 mb-5">
                                <div class="card h-100 shadow-sm border-0 rounded-3 bg-light p-3 position-relative">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-danger"></i>
                                        <div>
                                            <h4 class="mb-0 text-danger">Limbah B3</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="mb-0 text-muted">Transaksi Masuk Harian:</p>
                                        <p class="mb-0 text-danger">{{ $data['dailyTotalB3In'] ?? 0 }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="mb-0 text-muted">Transaksi Keluar Harian:</p>
                                        <p class="mb-0 text-danger">{{ $data['dailyTotalB3Out'] ?? 0 }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="mb-0 text-muted">Total Transaksi Harian:</p>
                                        <p class="mb-0 text-danger">{{ $data['dailyTotalB3'] ?? 0 }}</p>
                                    </div>
                                    <div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <a href="{{ route('waste.index', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                                   class="btn btn-outline-danger w-100 d-flex justify-content-between align-items-center">
                                                    Kelola Limbah B3
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="dropdown w-100">
                                                    <a class="btn btn-danger dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                       href="#" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                                       aria-expanded="false">
                                                        Tambah
                                                    </a>
                                                    <ul class="dropdown-menu w-100"
                                                        aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('waste.create', array_merge(request()->query(), ['waste' => 'b3', 'type'=>'in' ])) }}">
                                                                Limbah Masuk
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('waste.create', array_merge(request()->query(), ['waste' => 'b3', 'type'=>'out' ])) }}">
                                                                Limbah Keluar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- ... more cards here -->
                        </div>
                        <div class="card">
                            <h5 class="card-header">Summary</h5>
                            <div class="card-body">
                                <h6 class="card-title mt-4 text-center">Limbah Cairan</h6>
                                <hr class="border border-dark-subtle opacity-25">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="liquid-waste-table">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Input Hari Ini</th>
                                            <th>Output Hari Ini</th>
                                            <th>Total Hari Ini</th>
                                            <th>Total</th>
                                            <th>Satuan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- data will be filled here -->
                                        </tbody>
                                    </table>
                                </div>
                                <hr class="border mt-4 border-dark opacity-25">
                                <h6 class="card-title mt-4 text-center">Limbah B3</h6>
                                <hr class="border border-dark-subtle opacity-25">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="b3-waste-table">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Input Hari Ini</th>
                                            <th>Output Hari Ini</th>
                                            <th>Total Hari Ini</th>
                                            <th>Total</th>
                                            <th>Satuan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- data will be filled here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function () {
            const liquidWaste = $('#liquid-waste-table')
            liquidWaste.DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset('assets/lang/id/dataTables.json') }}'
                },
                ajax: {
                    url: '{{ route('dashboard.summary', ['waste' => 'liquid']) }}',
                    type: 'GET',
                    data: function (d) {
                        d.order[0].column--
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'daily_in', name: 'daily_in'},
                    {data: 'daily_out', name: 'daily_out'},
                    {data: 'daily_total', name: 'daily_total'},
                    {data: 'total', name: 'total'},
                    {data: 'unit', name: 'unit'}
                ],
            })

            const b3Waste = $('#b3-waste-table')
            b3Waste.DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: '{{ asset('assets/lang/id/dataTables.json') }}'
                },
                ajax: {
                    url: '{{ route('dashboard.summary', ['waste' => 'b3']) }}',
                    type: 'GET',
                    data: function (d) {
                        d.order[0].column--
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'daily_in', name: 'daily_in'},
                    {data: 'daily_out', name: 'daily_out'},
                    {data: 'daily_total', name: 'daily_total'},
                    {data: 'total', name: 'total'},
                    {data: 'unit', name: 'unit'}
                ],
            })
        })
    </script>
@endpush

@push('custom-css')
    <style>
        .card {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn {
            transition: background-color 0.3s, color 0.3s;
            font-weight: 600;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            color: #fff;
        }

        .dropdown-menu {
            border-radius: 10px;
        }

        /* Additional custom styles */
        .card-header {
            background-color: #fdf7e3;
            padding: 1.5rem;
            border-bottom: 2px solid #f8d47c;
        }

        .position-relative {
            position: relative;
        }

        .card-body {
            padding-top: 0;
        }

        .text-muted {
            font-size: 0.875rem;
        }
    </style>
@endpush
