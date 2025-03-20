<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            color: #333;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .info-item {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        .payment-records {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .payment-records th, .payment-records td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .payment-records th {
            background-color: #f8f9fa;
        }
        .notes {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 20px;
            }
            .section {
                page-break-inside: avoid;
            }
        }
        .hospital-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .hospital-info {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
        }
        .signature-section {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
        .signature-box {
            border-top: 1px solid #333;
            padding-top: 5px;
            text-align: center;
        }
        .signature-title {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="hospital-header">
        <div class="hospital-name">City General Hospital</div>
        <div class="hospital-info">
            123 Healthcare Avenue, Medical District<br>
            City, State 12345<br>
            Phone: (555) 123-4567 | Fax: (555) 123-4568<br>
            Email: info@citygeneralhospital.com
        </div>
    </div>
    
    <div class="section">
        <h2 style="text-align: center;">Invoice {{ $invoice->invoice_number }}</h2>
    </div>

    <div class="section">
        <div class="section-title">Invoice Information</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Date:</span>
                <span class="info-value">{{ optional($invoice->issued_date)->format('M d, Y') ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ ucfirst($invoice->status) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Amount:</span>
                <span class="info-value">${{ number_format($invoice->amount, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Due Date:</span>
                <span class="info-value">{{ optional($invoice->due_date)->format('M d, Y') ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Patient Information</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $invoice->patient->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $invoice->patient->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $invoice->patient->phone }}</span>
            </div>
        </div>
    </div>

    @if($invoice->appointment)
    <div class="section">
        <div class="section-title">Appointment Details</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Doctor:</span>
                <span class="info-value">{{ $invoice->appointment->doctor->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date & Time:</span>
                <span class="info-value">{{ optional($invoice->appointment->scheduled_at)->format('M d, Y h:i A') ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ ucfirst($invoice->appointment->status) }}</span>
            </div>
        </div>
    </div>
    @endif

    <div class="section">
        <div class="section-title">Payment Information</div>
        @if($invoice->payments && $invoice->payments->count() > 0)
            <table class="payment-records">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->payments as $payment)
                    <tr>
                        <td>{{ optional($payment->payment_date)->format('M d, Y') ?? 'N/A' }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td>{{ ucfirst($payment->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No payment records found.</p>
        @endif
    </div>

    @if($invoice->notes)
    <div class="section">
        <div class="section-title">Notes</div>
        <div class="notes">
            {{ $invoice->notes }}
        </div>
    </div>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Authorized Signature</div>
        </div>
        <div class="signature-box">
            <div class="signature-title">Patient/Guardian Signature</div>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Invoice
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>
