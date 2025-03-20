@extends('layouts.admin-layout')

@section('content')
    <h2>Billing Records</h2>
    <a href="{{ route('admin.billing.create') }}" class="btn btn-primary">Create Billing</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Patient</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Billing Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billings as $billing)
                <tr>
                    <td>{{ $billing->id }}</td>
                    <td>{{ $billing->invoice_number }}</td>
                    <td>{{ $billing->patient->name }}</td>
                    <td>${{ $billing->amount }}</td>
                    <td>{{ ucfirst($billing->status) }}</td>
                    <td>{{ $billing->billing_date }}</td>
                    <td>
                        <a href="{{ route('admin.billing.show', $billing->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.billing.edit', $billing->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.billing.destroy', $billing->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $billings->links() }}
@endsection
