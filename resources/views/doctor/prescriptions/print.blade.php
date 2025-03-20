<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription #{{ $prescription->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .clinic-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .clinic-info {
            font-size: 14px;
            color: #666;
        }
        .prescription-info {
            margin-bottom: 20px;
        }
        .patient-info {
            margin-bottom: 30px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2563eb;
        }
        .medicines {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .medicines th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }
        .medicines td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin-left: auto;
            padding-top: 5px;
            text-align: center;
        }
        .rx-symbol {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="clinic-name">Medical Clinic</div>
        <div class="clinic-info">
            123 Medical Center Drive<br>
            Phone: (555) 123-4567<br>
            Email: info@medicalclinic.com
        </div>
    </div>

    <div class="prescription-info">
        <div style="float: right">
            Date: {{ $prescription->created_at->format('M d, Y') }}<br>
            Prescription #: {{ $prescription->id }}
        </div>
        <div class="rx-symbol">℞</div>
    </div>

    <div class="patient-info">
        <div class="section-title">Patient Information</div>
        <div>
            <strong>Name:</strong> {{ $prescription->patient->name }}<br>
            <strong>Age:</strong> {{ $prescription->patient->age }} years<br>
            <strong>Contact:</strong> {{ $prescription->patient->phone }}
        </div>
    </div>

    <div class="diagnosis">
        <div class="section-title">Diagnosis</div>
        <p>{{ $prescription->diagnosis }}</p>
    </div>

    <div class="medicines-section">
        <div class="section-title">Prescribed Medicines</div>
        <table class="medicines">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Dosage</th>
                    <th>Duration</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->medicines as $medicine)
                    <tr>
                        <td>
                            {{ $medicine->name }}<br>
                            <small style="color: #666;">{{ $medicine->strength }} - {{ $medicine->dosage_form }}</small>
                        </td>
                        <td>{{ $medicine->pivot->dosage }}</td>
                        <td>{{ $medicine->pivot->duration }}</td>
                        <td>{{ $medicine->pivot->instructions }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($prescription->notes)
        <div class="notes">
            <div class="section-title">Additional Notes</div>
            <p>{{ $prescription->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <div class="signature-line">
            Dr. {{ $prescription->doctor->name }}<br>
            <small>License No: {{ $prescription->doctor->license_number ?? 'XXXXX' }}</small>
        </div>
    </div>
</body>
</html> 