@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h2 class="font-semibold text-xl leading-tight">
                            {{ __('Dashboard') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                   class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 border rounded-3 bg-light menu-item">
                                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-danger"></i>
                                        <div>
                                            <h4 class="mb-2 text-danger">Limbah B3</h4>
                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                                               class="text-decoration-none text-danger">
                                                                Kelola Limbah B3
                                                            </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="dropdown">
                                                                <a class="dropdown-toggle text-decoration-none text-danger"
                                                                   href="#"
                                                                   id="dropdownMenuLink" data-bs-toggle="dropdown"
                                                                   aria-expanded="false">
                                                                    Tambah
                                                                </a>
                                                                <ul class="dropdown-menu"
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
                                                <div class="col-md-auto">
                                                    <p class="mb-0 text-muted">
                                                        Total: {{ $totalB3 ?? 0 }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                   class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 border rounded-3 bg-light menu-item">
                                        <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-danger"></i>
                                        <div>
                                            <h4 class="mb-2 text-danger">Limbah B3</h4>
                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                                               class="text-decoration-none text-danger">
                                                                Kelola Limbah B3
                                                            </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="dropdown">
                                                                <a class="dropdown-toggle text-decoration-none text-danger"
                                                                   href="#"
                                                                   id="dropdownMenuLink" data-bs-toggle="dropdown"
                                                                   aria-expanded="false">
                                                                    Tambah
                                                                </a>
                                                                <ul class="dropdown-menu"
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
                                                <div class="col-md-auto">
                                                    <p class="mb-0 text-muted">
                                                        Total: {{ $totalB3 ?? 0 }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-css')
    <style>
        .menu-item {
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .menu-item:hover {
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #007bff;
        }

        h4 {
            font-weight: 600;
        }

        .btn-group .btn {
            border-radius: 50px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .dropdown-menu {
            border-radius: 10px;
        }

        .list-group-item {
            border: none;
            background-color: transparent;
        }

        .list-group-item a:hover {
            text-decoration: underline;
        }
    </style>
@endpush
