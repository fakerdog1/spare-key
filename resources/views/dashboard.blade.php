@extends('layouts.app')

@section('title', __('Dashboard'))

@section('header')
    <h2 class="h4 mb-0 text-secondary">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="card-text text-dark">
                                {{ __("You're logged in!") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection