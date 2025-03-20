@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Edit Invoice</h3>
                <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Invoice
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('cashier.invoices.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="border-start border-primary border-4 ps-3">Invoice Details</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="invoice_number" class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" value="{{ $invoice->invoice_number }}" readonly disabled>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="patient" class="form-label">Patient</label>
                        <input type="text" class="form-control" value="{{ $invoice->patient->name }}" readonly disabled>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                name="amount" id="amount" value="{{ old('amount', $invoice->amount) }}" required>
                        </div>
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                            name="due_date" id="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required>
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            name="description" id="description" rows="4" required>{{ old('description', $invoice->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                            <option value="Pending" {{ old('status', $invoice->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Paid" {{ old('status', $invoice->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Cancelled" {{ old('status', $invoice->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Invoice</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 