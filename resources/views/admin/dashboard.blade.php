@extends('layouts.admin')

@section('content')
    <div class="container-md">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row row-cols-1 row-cols-lg-2 justify-content-center g-4">
            <div class="col">
                <div class="card">
                    <h6 class="card-header text-uppercase">{{ __('User Dashboard') }}</h6>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Welcome {{ Auth::user()->name }}!
                    </div>
                </div>

            </div>
            <div class="col">
                <div class="card">
                    <h6 class="card-header text-uppercase">Projects</h6>

                    <div class="card-body">
                        <strong>Projects Counter:</strong> {{ $total_projects }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection