@extends('layouts.doctor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6">Update Schedule</h2>

                <form action="{{ route('doctor.schedule.store') }}" method="POST">
                    @csrf

                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="mb-6 border-b pb-6">
                        <h3 class="text-lg font-medium mb-4">{{ $day }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            <div>
                                <label for="{{ strtolower($day) }}_start" class="block text-sm font-medium text-gray-700">Start Time</label>
                                <input type="time" 
                                    name="schedule[{{ $loop->index }}][start_time]" 
                                    id="{{ strtolower($day) }}_start"
                                    value="{{ old('schedule.'.$loop->index.'.start_time', isset($schedules[$day]) ? $schedules[$day]->start_time : '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="{{ strtolower($day) }}_end" class="block text-sm font-medium text-gray-700">End Time</label>
                                <input type="time" 
                                    name="schedule[{{ $loop->index }}][end_time]" 
                                    id="{{ strtolower($day) }}_end"
                                    value="{{ old('schedule.'.$loop->index.'.end_time', isset($schedules[$day]) ? $schedules[$day]->end_time : '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="{{ strtolower($day) }}_max_appointments" class="block text-sm font-medium text-gray-700">Max Appointments</label>
                                <input type="number" 
                                    name="schedule[{{ $loop->index }}][max_appointments]" 
                                    id="{{ strtolower($day) }}_max_appointments"
                                    value="{{ old('schedule.'.$loop->index.'.max_appointments', isset($schedules[$day]) ? $schedules[$day]->max_appointments : '10') }}"
                                    min="1"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="{{ strtolower($day) }}_location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" 
                                    name="schedule[{{ $loop->index }}][location]" 
                                    id="{{ strtolower($day) }}_location"
                                    value="{{ old('schedule.'.$loop->index.'.location', isset($schedules[$day]) ? $schedules[$day]->location : '') }}"
                                    placeholder="Room number or clinic location"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="{{ strtolower($day) }}_consultation_type" class="block text-sm font-medium text-gray-700">Consultation Type</label>
                                <select name="schedule[{{ $loop->index }}][consultation_type]" 
                                    id="{{ strtolower($day) }}_consultation_type"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="in-person" {{ old('schedule.'.$loop->index.'.consultation_type', isset($schedules[$day]) ? $schedules[$day]->consultation_type : '') == 'in-person' ? 'selected' : '' }}>In-person</option>
                                    <option value="virtual" {{ old('schedule.'.$loop->index.'.consultation_type', isset($schedules[$day]) ? $schedules[$day]->consultation_type : '') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                                    <option value="both" {{ old('schedule.'.$loop->index.'.consultation_type', isset($schedules[$day]) ? $schedules[$day]->consultation_type : '') == 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="schedule[{{ $loop->index }}][day]" value="{{ $day }}">
                    </div>
                    @endforeach

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('doctor.schedule') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection