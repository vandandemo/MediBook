@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Edit Lab Report</h2>
                    <a href="{{ route('doctor.lab-reports.show', $labReport) }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                        Cancel
                    </a>
                </div>

                <form action="{{ route('doctor.lab-reports.update', $labReport) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Test Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Test Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="test_type" class="block text-sm font-medium text-gray-700">Test Type</label>
                                    <select name="test_type" id="test_type" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="blood" {{ $labReport->test_type == 'blood' ? 'selected' : '' }}>Blood Test</option>
                                        <option value="urine" {{ $labReport->test_type == 'urine' ? 'selected' : '' }}>Urine Test</option>
                                        <option value="xray" {{ $labReport->test_type == 'xray' ? 'selected' : '' }}>X-Ray</option>
                                        <option value="mri" {{ $labReport->test_type == 'mri' ? 'selected' : '' }}>MRI</option>
                                    </select>
                                    @error('test_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="test_date" class="block text-sm font-medium text-gray-700">Test Date</label>
                                    <input type="date" name="test_date" id="test_date" required
                                        value="{{ $labReport->test_date instanceof \Carbon\Carbon ? $labReport->test_date->format('Y-m-d') : $labReport->test_date }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('test_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="pending" {{ $labReport->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $labReport->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $labReport->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Results and Comments -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Results and Comments</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="results" class="block text-sm font-medium text-gray-700">Test Results</label>
                                    <textarea name="results" id="results" rows="4" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $labReport->results }}</textarea>
                                    @error('results')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="comments" class="block text-sm font-medium text-gray-700">Doctor's Comments</label>
                                    <textarea name="comments" id="comments" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $labReport->comments }}</textarea>
                                    @error('comments')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-gray-50 p-6 rounded-lg md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Additional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="findings" class="block text-sm font-medium text-gray-700">Findings</label>
                                    <textarea name="findings" id="findings" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $labReport->findings }}</textarea>
                                </div>

                                <div>
                                    <label for="conclusion" class="block text-sm font-medium text-gray-700">Conclusion</label>
                                    <textarea name="conclusion" id="conclusion" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $labReport->conclusion }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="recommendations" class="block text-sm font-medium text-gray-700">Recommendations</label>
                                    <textarea name="recommendations" id="recommendations" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $labReport->recommendations }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Lab Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 