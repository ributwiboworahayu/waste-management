@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Dashboard') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <div class="d-flex align-items-center p-1 border rounded bg-light menu-item">
                                    <i class="bi bi-dropbox fs-3 me-3"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-2">Limbah Cair</h4>
                                        <div class="row mb-3">
                                            <div class="col-md-8">
                                                <div class="btn-group">
                                                    <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'cair' ])) }}"
                                                       class="btn btn-outline-primary">
                                                        Kelola Limbah Cair
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('waste.create', array_merge(request()->query(), ['waste' => 'cair', 'type'=>'in' ])) }}">
                                                                Limbah Masuk
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('waste.create', array_merge(request()->query(), ['waste' => 'cair', 'type'=>'out' ])) }}">
                                                                Limbah Keluar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                   class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 border rounded bg-light menu-item">
                                        <i class="bi bi-dropbox fs-3 me-3"></i>
                                        <div>
                                            <h4 class="mb-2">Limbah B3</h4>
                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <a href="{{ route('waste.list', array_merge(request()->query(), ['waste' => 'b3' ])) }}"
                                                               class="text-decoration-none">
                                                                Kelola Limbah B3
                                                            </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="dropdown">
                                                                <a class="dropdown-toggle text-decoration-none" href="#"
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
            background-color: #e9ecef;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
