@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Patient Dashboard') }}</div>

                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ Auth::guard('patient')->user()->name }}!</h5>
                    
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Appointments</h5>
                                    <p class="card-text">Book appointments</p>
                                    <a href="#" class="btn btn-light">Schedule Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Medical Records</h5>
                                    <p class="card-text">View your records</p>
                                    <a href="#" class="btn btn-light">View Records</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Prescriptions</h5>
                                    <p class="card-text">View prescriptions</p>
                                    <a href="#" class="btn btn-light">View Prescriptions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection