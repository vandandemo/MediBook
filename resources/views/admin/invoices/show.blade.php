@extends('layouts.admin-layout')

@section('content')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-4">
                <button onclick="window.print()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    {{ __('Print Invoice') }}
                </button>
                <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit Invoice') }}
                </a>
                <a href="{{ route('admin.invoices.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Invoice Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">{{ __('Invoice Information') }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Invoice Number') }}</p>
                                    <p class="font-medium">{{ $invoice->invoice_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Date') }}</p>
                                    <p class="font-medium">{{ $invoice->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Status') }}</p>
                                    <p class="font-medium">
                                        <span class="px-2 py-1 text-sm rounded-full {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Amount') }}</p>
                                    <p class="font-medium">${{ number_format($invoice->amount, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">{{ __('Patient Information') }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Name') }}</p>
                                    <p class="font-medium">{{ $invoice->patient->name ?? ($invoice->appointment->patient->name ?? 'N/A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Email') }}</p>
                                    <p class="font-medium">{{ $invoice->patient->email ?? ($invoice->appointment->patient->email ?? 'N/A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Phone') }}</p>
                                    <p class="font-medium">{{ $invoice->patient->phone ?? ($invoice->appointment->patient->phone ?? 'N/A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Information -->
                        @if($invoice->appointment)
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">{{ __('Appointment Details') }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Doctor') }}</p>
                                    <p class="font-medium">{{ $invoice->appointment->doctor->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Date & Time') }}</p>
                                    <p class="font-medium">{{ $invoice->appointment->appointment_date ? $invoice->appointment->appointment_date->format('M d, Y H:i A') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Status') }}</p>
                                    <p class="font-medium">
                                        <span class="px-2 py-1 text-sm rounded-full {{ $invoice->appointment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($invoice->appointment->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Payment Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">{{ __('Payment Information') }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @if($invoice->payments->count() > 0)
                                    @foreach($invoice->payments as $payment)
                                        <div>
                                            <p class="text-sm text-gray-600">{{ __('Payment Date') }}</p>
                                            <p class="font-medium">{{ $payment->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">{{ __('Payment Method') }}</p>
                                            <p class="font-medium">{{ ucfirst($payment->payment_method) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">{{ __('Amount Paid') }}</p>
                                            <p class="font-medium">${{ number_format($payment->amount, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">{{ __('Transaction ID') }}</p>
                                            <p class="font-medium">{{ $payment->transaction_id }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-span-2">
                                        <p class="text-gray-500">{{ __('No payment records found.') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($invoice->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold">{{ __('Notes') }}</h3>
                            <p class="mt-2 text-gray-700">{{ $invoice->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style media="print">
    @page {
        size: A4;
        margin: 1.6cm;
    }
    body {
        margin: 0;
        padding: 0;
        line-height: 1.4;
        font-size: 12pt;
    }
    nav, footer, .no-print {
        display: none !important;
    }
    .print-only {
        display: block !important;
    }
    .shadow-sm {
        box-shadow: none !important;
    }
    .bg-white {
        background-color: white !important;
    }
    .text-gray-900 {
        color: black !important;
    }
    .py-12 {
        padding: 1cm 0 !important;
    }
    .max-w-7xl {
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .grid {
        display: grid !important;
        gap: 1rem !important;
    }
    .font-medium {
        font-weight: 500 !important;
    }
    .text-sm {
        font-size: 10pt !important;
    }
    .rounded-full {
        border-radius: 9999px !important;
    }
    .space-y-4 > * + * {
        margin-top: 1rem !important;
    }
</style>
<style media="screen">
    .max-w-7xl {
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .grid {
        display: grid !important;
        gap: 1rem !important;
    }
    .font-medium {
        font-weight: 500 !important;
    }
    .text-sm {
        font-size: 0.875rem !important;
    }
    .rounded-full {
        border-radius: 9999px !important;
    }
    .space-y-4 > * + * {
        margin-top: 1rem !important;
    }
</style>
@endpush
