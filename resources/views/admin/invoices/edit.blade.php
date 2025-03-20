@extends('layouts.admin-layout')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-indigo-800">Edit Invoice</h2>
                        <a href="{{ route('admin.invoices.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>

                    <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="bg-white shadow-md overflow-hidden sm:rounded-lg border border-indigo-100 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Patient Information -->
                                <div class="col-span-2">
                                    <h3 class="text-lg font-semibold text-indigo-700 mb-4">Patient Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                                            <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach($patients as $patient)
                                                    <option value="{{ $patient->id }}" {{ $invoice->patient_id == $patient->id ? 'selected' : '' }}>
                                                        {{ $patient->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Invoice Details -->
                                <div class="col-span-2">
                                    <h3 class="text-lg font-semibold text-indigo-700 mb-4">Invoice Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                            <input type="number" step="0.01" name="amount" id="amount" value="{{ $invoice->amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                                            <input type="date" name="due_date" id="due_date" value="{{ optional($invoice->due_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                            <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="cash" {{ $invoice->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="credit_card" {{ $invoice->payment_method === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                                <option value="debit_card" {{ $invoice->payment_method === 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                                <option value="insurance" {{ $invoice->payment_method === 'insurance' ? 'selected' : '' }}>Insurance</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="pending" {{ $invoice->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="partially_paid" {{ $invoice->status === 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                                <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                                <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="insurance_claim_id" class="block text-sm font-medium text-gray-700">Insurance Claim ID</label>
                                            <input type="text" name="insurance_claim_id" id="insurance_claim_id" value="{{ $invoice->insurance_claim_id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label for="insurance_claim_status" class="block text-sm font-medium text-gray-700">Insurance Claim Status</label>
                                            <select name="insurance_claim_status" id="insurance_claim_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ !$invoice->insurance_claim_id ? 'disabled' : '' }}>
                                                <option value="pending" {{ optional($invoice->insuranceClaim)->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ optional($invoice->insuranceClaim)->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ optional($invoice->insuranceClaim)->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </div>

                                        <div class="col-span-2">
                                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $invoice->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-4">
                                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Invoice
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection