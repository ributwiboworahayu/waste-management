@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Dashboard') }}
                        </h2>
                    </div>

                    <div class="card-body">
                        <p class="lead">You're logged in!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
