@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Create New Billing</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.billing.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Select Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control" required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="services" class="form-label">Services Provided</label>
                    <input type="text" name="services" id="services" class="form-control" placeholder="E.g., Consultation, Lab Test" required>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Total Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
                </div>

                <div class="mb-3">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Create Billing</button>
            </form>
        </div>
    </div>
</div>
@endsection
