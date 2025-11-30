@extends('layouts.sidebar')
@section('title', 'Dashboard Admin')
@section('content')

<div class="flex flex-col md:flex-row gap-4 mb-8 items-stretch">

        <div
            class="flex-1 bg-linear-to-b from-brand-secondary to-[#81E1DD] text-white px-6 py-4 rounded-xl shadow-md flex items-center">
            <h2 class="text-xl md:text-2xl font-bold tracking-wide">
                Selamat Datang, {{ explode(' ', $data['profile']['name'])[0] }}! Semangat Kerja!
            </h2>
        </div>

        <div
            class="w-full md:w-auto bg-linear-to-b from-brand-secondary to-[#81E1DD] text-white px-6 py-4 rounded-xl shadow-md flex items-center gap-4">
            <div class="bg-white text-brand-secondary p-2 rounded-full w-10 h-10 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>

            <div class="text-left">
                <p class="font-bold text-sm leading-tight">{{ $data['profile']['name'] }}</p>
                <p class="text-xs text-teal-50 opacity-90">{{ $data['profile']['email'] }}</p>
            </div>
        </div>

    </div>

    <div class="grid gap-6 mb-8 items-stretch">

        <div class="flex gap-6 h-full">

            {{-- KARTU 1 --}}
            <div class="bg-white p-6 rounded-xl shadow-sm text-center flex-1 flex flex-col justify-center">
                <h3 class="text-4xl font-bold text-brand-secondary">{{ $data['stats']['registered_patients'] }}</h3>
                <p class="text-brand-secondary font-medium mt-1">Pasien Terdaftar</p>
            </div>

            {{-- KARTU 2 --}}
            <div class="bg-white p-6 rounded-xl shadow-sm text-center flex-1 flex flex-col justify-center">
                <h3 class="text-4xl font-bold text-brand-secondary">{{ $data['stats']['new_patients'] }}</h3>
                <p class="text-brand-secondary font-medium mt-1">Pasien Baru</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
        <div class="bg-teal-500 text-white px-4 py-2 rounded-t-lg -mt-6 -mx-6 mb-4">
            <h3 class="font-bold">Total Pemasukan</h3>
            <span class="text-sm text-gray-500 font-bold">Tahun {{ date('Y') }}</span>
        </div>
        <div class="h-64">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="bg-brand-secondary px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="text-white font-bold text-lg tracking-wide">Reservasi Pasien Terbaru</h3>

            <div class="relative w-full md:w-64">
                <input type="text" placeholder="Cari"
                    class="w-full pl-4 pr-10 py-2 rounded-full text-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-200 shadow-sm" />
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-teal-50 text-teal-600 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="py-4 pl-6">Nama Lengkap</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($data['reservations'] as $patient)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="pl-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="avatar placeholder">
                                        <div
                                            class="{{ $patient['color'] }} rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm shadow-sm">
                                            <span>{{ $patient['initial'] }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $patient['name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $patient['email'] }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-gray-600 font-medium text-sm">{{ $patient['contact'] }}</td>

                            <td class="text-gray-600 text-sm truncate max-w-[150px]">{{ $patient['address'] }}</td>

                            <td class="text-gray-600 font-medium text-sm">
                                {{ $patient['status'] }}
                            </td>

                            <td class="text-center">
                                {{-- LOGIKA: --}}
                                {{-- 1. Kalau 'Booking' -> Muncul tombol 'Diperiksa' --}}
                                @if ($patient['status'] == 'Booking')
                                    <form action="{{ route('admin.reservasi.confirm', $patient['id']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="next_status" value="Diperiksa">
                                        <button
                                            class="btn btn-sm bg-brand-dark text-white hover:bg-brand-dark/90 border-none w-24 rounded-full font-normal shadow-md">
                                            Diperiksa
                                        </button>
                                    </form>

                                    {{-- 2. Kalau 'Diperiksa' -> Muncul tombol 'Selesai' --}}
                                @elseif($patient['status'] == 'Diperiksa')
                                    <form action="{{ route('admin.reservasi.confirm', $patient['id']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="next_status" value="Selesai">
                                        <button
                                            class="btn btn-sm bg-brand-dark text-white hover:bg-brand-dark/90 border-none w-24 rounded-full font-normal shadow-md">
                                            Selesai
                                        </button>
                                    </form>

                                    {{-- 3. Kalau 'Selesai' -> Strip (-) --}}
                                @else
                                    <span class="text-gray-400 font-bold">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
    // Ambil Data dari Controller (Dinamis dari DB)
    // Object.keys untuk Label (Gigi, Mata)
    // Object.values untuk Angka (10, 5)

    const lineData = @json($data['chart_line']);

    // LINE CHART CONFIG
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const gradient = ctxLine.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(20, 184, 166, 0.2)');
    gradient.addColorStop(1, 'rgba(20, 184, 166, 0)');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'],
            datasets: [{
                data: lineData,
                borderColor: '#14b8a6',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: '#1e1b4b'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e1b4b', padding: 12 } },
            scales: {
                x: { grid: { display: false }, ticks: { display: true }, border: { display: false } },
                y: { grid: { color: '#f3f4f6' }, border: { display: false }, ticks: { display: true } }
            }
        }
    });
</script>

@endsection
