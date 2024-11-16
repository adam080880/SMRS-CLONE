@extends('header')

@section('title','Buat Jadwal')

@section('page')

<div class="flex h-screen bg-red-300">
    {{-- Sidebar dengan warna biru penuh dan logo yang konsisten --}}
    <div class="bg-white w-1/5 min-h-screen p-6 flex flex-col items-center">
        <!-- Logo Bunga -->
        <div class="mb-8">
            <img src="{{ asset('Logo.jpg') }}" alt="Logo" class="w-50">
            <h2 class="text-2xl font-semibold text-gray-700">⸻⸻⸻⸻⸻</h2>
        </div>
        <!-- Sidebar menu items -->
        <ul class="w-full">
            <li class="mb-4">
                <button onclick="location.href='{{ route('dashboard') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                    </svg>
                    Dashboard
                </button>
            </li>
            <li class="mb-4">
                <button onclick="location.href='{{ route('ajuanjadwal') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                    </svg>
                    Verifikasi Jadwal
                </button>
            </li>
            <li class="mb-4">
                <button onclick="location.href='{{ route('ajuanruang') }}'" class="flex items-center w-full text-gray-700 bg-gray-300 shadow-2xl rounded-lg p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-10S17.523 2 12 2z" />
                    </svg>
                    Verifikasi Ruang Kelas
                </button>
            </li>
        </ul>
    </div>

    {{-- Main Content --}}
    <div id="main-content" class="w-4/5 p-8 overflow-y-auto">
        <div class="bg-white border border-gray-300 rounded-3xl shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6 text-red-400 text-center">Jadwal Kuliah S1 {{ $data->prodi }}</h1>

            <div class="overflow-x-auto">
                @php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    $times = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];
                @endphp

                <table class="min-w-full bg-white text-center border border-gray-200">
                    <thead class="bg-red-400 text-white">
                        <tr>
                            <th class="py-3 px-4 text-sm font-semibold border-r border-white">Jam</th>
                            @foreach($days as $day)
                                <th class="py-3 px-4 text-sm font-semibold border-r border-white">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($times as $timeIndex => $time)
                            <tr class="{{ $timeIndex % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="py-3 px-4 font-semibold border-r border-gray-200">{{ $time }}</td>
                                @foreach($days as $dayIndex => $day)
                                    <td class="py-3 px-4 border-r border-gray-200">
                                        @foreach($data as $schedule)
                                            @if($schedule->hari == $day && substr($schedule->jammulai, 0, 2) == substr($time, 0, 2))
                                                <div class="p-3 mb-2 border border-gray-300 rounded-lg bg-red-100 shadow-sm">
                                                    <span class="text-xs font-bold text-gray-900">{{ $schedule->matakuliah }} {{ $schedule->kelas }}</span>
                                                    <p class="text-xs text-gray-700">Semester 1 / {{ $schedule->sks }} SKS <br> {{ $schedule->jammulai }} - {{ $schedule->jamselesai }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
 