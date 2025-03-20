<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
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
        
        .invoice-info {
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            background-color: #f5f5f5;
            text-align: left;
            padding: 10px;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .text-right {
            text-align: right;
        }
        
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }
        
        .status-paid {
            background-color: #c3e6cb;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f5c6cb;
            color: #721c24;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .button {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 20px 5px 0 0;
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
    
    <h1 class="title">Invoice</h1>
    
    <hr>
    
    <div class="invoice-info">
        <div class="info-block">
            <h3>Bill To</h3>
            <div class="info-row">
                <div class="info-label">Name:</div>
                <div>{{ $invoice->patient->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Patient ID:</div>
                <div>{{ $invoice->patient->patient_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div>{{ $invoice->patient->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div>{{ $invoice->patient->phone }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Address:</div>
                <div>{{ $invoice->patient->address }}</div>
            </div>
        </div>
        
        <div class="info-block">
            <h3>Invoice Details</h3>
            <div class="info-row">
                <div class="info-label">Invoice No:</div>
                <div>{{ $invoice->invoice_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date:</div>
                <div>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Due Date:</div>
                <div>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div>
                    <span class="status status-{{ strtolower($invoice->status) }}">
                        {{ $invoice->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->description }}</td>
                <td class="text-right">₱{{ number_format($invoice->amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="1" class="text-right"><strong>Total:</strong></td>
                <td class="text-right amount">₱{{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    @if($invoice->appointment)
    <div class="info-block">
        <h3>Appointment Details</h3>
        <div class="info-row">
            <div class="info-label">Doctor:</div>
            <div>Dr. {{ $invoice->appointment->doctor->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date:</div>
            <div>{{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('M d, Y h:i A') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Type:</div>
            <div>{{ $invoice->appointment->appointment_type }}</div>
        </div>
    </div>
    @endif
    
    <div class="footer">
        <p>This is a computer-generated invoice and requires no signature.</p>
        <p>Payment is due by {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}. Please make payment to the account details provided above.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
    
    <div class="no-print">
        <button class="button" onclick="window.print()">Print Invoice</button>
        <a href="{{ route('cashier.invoices.show', $invoice->id) }}" class="button" style="background-color: #6c757d; text-decoration: none;">Back to Invoice</a>
    </div>
</body>
</html> 