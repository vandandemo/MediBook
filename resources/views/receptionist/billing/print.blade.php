<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .patient-info, .invoice-details {
            width: 48%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .invoice-header {
                margin-bottom: 20px;
            }
            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Medical Clinic</h1>
        <p>123 Medical Street, City, State 12345</p>
        <p>Phone: (123) 456-7890 | Email: info@medicalclinic.com</p>
    </div>

    <div class="invoice-info">
        <div class="patient-info">
            <h3>Patient Information</h3>
            <p><strong>Name:</strong> {{ $invoice->appointment->patient->name ?? 'N/A' }}</p>
            <p><strong>ID:</strong> {{ $invoice->appointment->patient->id ?? 'N/A' }}</p>
            <p><strong>Contact:</strong> {{ $invoice->appointment->patient->phone ?? 'N/A' }}</p>
        </div>
        <div class="invoice-details">
            <h3>Invoice Information</h3>
            <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->description }}</td>
                <td>${{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="total">Total Amount:</td>
                <td>${{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($invoice->payments->count() > 0)
    <h3>Payment History</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->payments as $payment)
            <tr>
                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                <td>{{ $payment->reference_number ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>Thank you for choosing our medical services.</p>
        <p>This is a computer-generated invoice. No signature is required.</p>
        <p>For any questions, please contact our billing department.</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Print Invoice</button>
    </div>
</body>
</html> 