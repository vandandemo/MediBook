<!DOCTYPE html>
<html>
<head>
    <title>Receipt - Transaction #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Hospital Name</h2>
        <p>123 Hospital Street, City, Country</p>
        <p>Phone: (123) 456-7890</p>
        <p>Email: info@hospital.com</p>
        <h3>Payment Receipt</h3>
    </div>

    <div class="receipt-info">
        <p><strong>Receipt Number:</strong> #{{ $transaction->id }}</p>
        <p><strong>Date:</strong> {{ $transaction->transaction_date->format('M d, Y H:i') }}</p>
        <p><strong>Patient:</strong> {{ $transaction->patient->name }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($transaction->payment_method) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
        @if($transaction->reference_number)
        <p><strong>Reference Number:</strong> {{ $transaction->reference_number }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₱{{ number_format($item->unit_price, 2) }}</td>
                <td>₱{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Amount:</td>
                <td class="total">₱{{ number_format($transaction->amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($transaction->notes)
    <div class="notes">
        <p><strong>Notes:</strong></p>
        <p>{{ $transaction->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your payment!</p>
        <p>This is an official receipt.</p>
        <p>Generated on: {{ now()->format('M d, Y H:i:s') }}</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html> 