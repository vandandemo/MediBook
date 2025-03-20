@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Lab Reports</h2>
                    <a href="{{ route('doctor.lab-reports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Request New Lab Test
                    </a>
                </div>

                <!-- Search and Filter -->
                <div class="mb-6 flex gap-4">
                    <input type="text" placeholder="Search by patient name..." class="rounded-md border-gray-300 w-full md:w-1/3">
                    <select class="rounded-md border-gray-300">
                        <option value="all">All Types</option>
                        <option value="blood">Blood Test</option>
                        <option value="urine">Urine Test</option>
                        <option value="xray">X-Ray</option>
                        <option value="mri">MRI</option>
                    </select>
                </div>

                <!-- Lab Reports Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($labReports as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->patient->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $report->test_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($report->status == 'completed') bg-green-100 text-green-800
                                        @elseif($report->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('doctor.lab-reports.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                    @if($report->status == 'completed')
                                    <a href="{{ route('doctor.lab-reports.download', $report->id) }}" class="text-green-600 hover:text-green-900">Download</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No lab reports found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $labReports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add search and filter functionality here
</script>
@endsection