<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 14px;
            margin-top: 0;
            color: #666;
        }
        
        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .info-block {
            margin-bottom: 20px;
        }
        
        .info-block h3 {
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        
        .amount {
            font-size: 18px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #666;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .print-btn {
                display: none;
            }
        }
        
        .print-btn {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 20px 0;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">{{ config('app.name') }}</div>
        <p class="subtitle">123 Hospital Address, City, Country | Phone: (123) 456-7890 | Email: info@hospital.com</p>
    </div>
    
    <h1 class="title">Payment Receipt</h1>
    
    <hr>
    
    <div class="receipt-info">
        <div class="info-block">
            <h3>Receipt Details</h3>
            <div class="info-row">
                <div class="info-label">Receipt No:</div>
                <div>{{ $payment->receipt_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date:</div>
                <div>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Payment Method:</div>
                <div>{{ $payment->payment_method }}</div>
            </div>
            @if($payment->reference_number)
            <div class="info-row">
                <div class="info-label">Reference Number:</div>
                <div>{{ $payment->reference_number }}</div>
            </div>
            @endif
        </div>
        
        <div class="info-block">
            <h3>Patient Information</h3>
            <div class="info-row">
                <div class="info-label">Patient Name:</div>
                <div>{{ $payment->invoice->patient->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Patient ID:</div>
                <div>{{ $payment->invoice->patient->patient_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div>{{ $payment->invoice->patient->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div>{{ $payment->invoice->patient->phone }}</div>
            </div>
        </div>
    </div>
    
    <div class="info-block">
        <h3>Payment Details</h3>
        <div class="info-row">
            <div class="info-label">Invoice Number:</div>
            <div>{{ $payment->invoice->invoice_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Invoice Date:</div>
            <div>{{ \Carbon\Carbon::parse($payment->invoice->invoice_date)->format('M d, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Description:</div>
            <div>{{ $payment->invoice->description }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Amount Paid:</div>
            <div class="amount">₱{{ number_format($payment->amount, 2) }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This is a computer-generated receipt and requires no signature.</p>
        <p>Thank you for your payment. For any questions, please contact our billing department.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
    
    <button class="print-btn" onclick="window.print()">Print Receipt</button>
    <a href="{{ route('cashier.payments.show', $payment->id) }}" class="print-btn" style="background-color: #6c757d; text-decoration: none;">Back to Payment</a>
</body>
</html> 