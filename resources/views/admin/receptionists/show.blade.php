@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Receptionist Details</h3>
                    <a href="{{ route('admin.receptionists.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light">ID</th>
                                    <td>{{ $receptionist->id }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Name</th>
                                    <td>{{ $receptionist->name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td>{{ $receptionist->email }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Phone</th>
                                    <td>{{ $receptionist->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span class="badge {{ $receptionist->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $receptionist->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created At</th>
                                    <td>{{ $receptionist->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Updated At</th>
                                    <td>{{ $receptionist->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.receptionists.edit', $receptionist->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Receptionist
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
