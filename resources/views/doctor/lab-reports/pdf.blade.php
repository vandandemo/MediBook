<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Report - {{ $labReport->report_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laboratory Report</h1>
        <p>Report Number: {{ $labReport->report_number }}</p>
    </div>

    <div class="section">
        <div class="section-title">Patient Information</div>
        <div class="info-row">
            <span class="label">Name:</span>
            <span>{{ $labReport->patient->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Date Created:</span>
            <span>{{ $labReport->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Test Information</div>
        <div class="info-row">
            <span class="label">Test Type:</span>
            <span>{{ $labReport->test_type }}</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span>{{ ucfirst($labReport->status) }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Test Results</div>
        <div>
            {!! $labReport->results !!}
        </div>
    </div>

    @if($labReport->comments)
    <div class="section">
        <div class="section-title">Doctor's Comments</div>
        <div>
            {!! $labReport->comments !!}
        </div>
    </div>
    @endif
</body>
</html>