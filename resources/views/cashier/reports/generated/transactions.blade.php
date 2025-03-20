<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
            max-width: 1000px;
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
        
        .report-info {
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
        
        .status-completed {
            background-color: #c3e6cb;
            color: #155724;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .summary-card h4 {
            margin: 0 0 10px 0;
            color: #666;
            font-size: 14px;
        }
        
        .summary-card p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .payment-methods {
            margin-bottom: 30px;
        }
        
        .payment-method-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .payment-method-card h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .payment-method-card p {
            margin: 5px 0;
            color: #666;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            .summary-card, .payment-method-card {
                border: 1px solid #ddd;
                background-color: white;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
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
    
    <h1 class="title">Transactions Report</h1>
    
    <hr>
    
    <div class="report-info">
        <div class="info-block">
            <h3>Report Details</h3>
            <div class="info-row">
                <div class="info-label">Date Range:</div>
                <div>{{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Generated By:</div>
                <div>{{ auth()->guard('cashier')->user()->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Generated On:</div>
                <div>{{ now()->format('M d, Y H:i:s') }}</div>
            </div>
        </div>
    </div>
    
    <div class="summary-grid">
        <div class="summary-card">
            <h4>Total Transactions</h4>
            <p>{{ $transactions->count() }}</p>
        </div>
        <div class="summary-card">
            <h4>Total Amount</h4>
            <p>₱{{ number_format($totalAmount, 2) }}</p>
        </div>
        <div class="summary-card">
            <h4>Average Transaction</h4>
            <p>₱{{ number_format($transactions->count() > 0 ? $totalAmount / $transactions->count() : 0, 2) }}</p>
        </div>
    </div>
    
    <div class="payment-methods">
        <h3>Payment Methods Summary</h3>
        @foreach($paymentMethods as $method => $data)
        <div class="payment-method-card">
            <h4>{{ $method }}</h4>
            <p>Count: {{ $data['count'] }}</p>
            <p>Total: ₱{{ number_format($data['total'], 2) }}</p>
            <p>Percentage: {{ number_format($data['percentage'], 1) }}%</p>
        </div>
        @endforeach
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Patient</th>
                <th>Invoice</th>
                <th class="text-right">Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->transaction_date->format('M d, Y H:i') }}</td>
                <td>{{ $transaction->patient->name }}</td>
                <td>{{ $transaction->invoice->invoice_number }}</td>
                <td class="text-right">₱{{ number_format($transaction->amount, 2) }}</td>
                <td>{{ $transaction->payment_method }}</td>
                <td>
                    <span class="status status-completed">Completed</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No transactions found for the selected date range.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated report and requires no signature.</p>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
    
    <div class="no-print">
        <button class="button" onclick="window.print()">Print Report</button>
        <a href="{{ route('cashier.reports.index') }}" class="button" style="background-color: #6c757d; text-decoration: none;">Back to Reports</a>
    </div>
</body>
</html> 