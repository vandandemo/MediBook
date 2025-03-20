@extends('layouts.cashier-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-gradient-success text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title h4 mb-0 fw-bold">Process Payment</h3>
                <a href="{{ route('cashier.invoices.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Invoices
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('cashier.payments.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="border-start border-success border-4 ps-3">Invoice Information</h5>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="invoice_id" class="form-label">Select Invoice</label>
                        <select class="form-select @error('invoice_id') is-invalid @enderror" name="invoice_id" id="invoice_id" required>
                            <option value="">-- Select Invoice --</option>
                            @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ old('invoice_id', request('invoice_id')) == $invoice->id ? 'selected' : '' }}
                                data-amount="{{ $invoice->amount }}">
                                {{ $invoice->invoice_number }} - {{ $invoice->patient->name }} 
                                (₱{{ number_format($invoice->amount, 2) }})
                            </option>
                            @endforeach
                        </select>
                        @error('invoice_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="border-start border-success border-4 ps-3">Payment Details</h5>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                name="amount" id="amount" value="{{ old('amount') }}" required>
                        </div>
                        <small class="text-muted">Amount must match the invoice total.</small>
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="payment_date" class="form-label">Payment Date</label>
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                            name="payment_date" id="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
                        @error('payment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method" required>
                            <option value="">-- Select Payment Method --</option>
                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="Debit Card" {{ old('payment_method') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                            <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="Insurance" {{ old('payment_method') == 'Insurance' ? 'selected' : '' }}>Insurance</option>
                        </select>
                        @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="reference_number" class="form-label">Reference Number</label>
                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                            name="reference_number" id="reference_number" value="{{ old('reference_number') }}">
                        <small class="text-muted">For card payments, bank transfers, or insurance claims.</small>
                        @error('reference_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                            name="notes" id="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cashier.invoices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Process Payment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceSelect = document.getElementById('invoice_id');
        const amountInput = document.getElementById('amount');
        
        invoiceSelect.addEventListener('change', function() {
            if (this.value !== '') {
                const selectedOption = this.options[this.selectedIndex];
                const invoiceAmount = selectedOption.getAttribute('data-amount');
                amountInput.value = invoiceAmount;
            } else {
                amountInput.value = '';
            }
        });
        
        // Set initial amount if invoice is pre-selected
        if (invoiceSelect.value !== '') {
            const selectedOption = invoiceSelect.options[invoiceSelect.selectedIndex];
            const invoiceAmount = selectedOption.getAttribute('data-amount');
            amountInput.value = invoiceAmount;
        }
    });
</script>
@endpush 