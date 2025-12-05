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
                <p class="text-brand-secondary font-medium mt-1">Pasien Baru Bulan Ini</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
            {{-- HEADER CHART dengan Form Filter di dalamnya --}}
            <div class="bg-linear-to-b from-brand-secondary to-[#81E1DD] text-white px-4 py-2 rounded-t-lg -mt-6 -mx-6 mb-4 flex justify-between items-center">
                <h3 class="font-bold">Pasien SI-Klinik</h3>
                
                {{-- FORM FILTER BULAN (Diselipkan di sini tanpa merusak layout luar) --}}
                <form action="{{ route('admin.dashboard') }}" method="GET">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="month" onchange="this.form.submit()" class="bg-white/20 text-white text-sm border-none rounded focus:ring-0 cursor-pointer font-bold">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" class="text-gray-800" {{ $data['filters']['month'] == $m ? 'selected' : '' }}>
                                Bulan {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="h-64 w-full relative">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="bg-linear-to-b from-brand-secondary to-[#81E1DD] px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="text-white font-bold text-lg tracking-wide">Reservasi Pasien Terbaru</h3>

            {{-- FORM SEARCH (Menggantikan div wrapper sebelumnya) --}}
            <form action="{{ route('admin.dashboard') }}" method="GET" class="relative w-full md:w-64">
                @if(request('month'))
                    <input type="hidden" name="month" value="{{ request('month') }}">
                @endif

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari"
                    class="w-full pl-4 pr-10 py-2 rounded-full text-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-200 shadow-sm" />
                
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-teal-50 text-teal-600 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="py-4 pl-6">Nama Lengkap</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse ($data['reservations'] as $patient)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="pl-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="avatar placeholder">
                                    <div class="{{ $patient['color'] }} rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm shadow-sm">
                                        <span>{{ $patient['initial'] }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $patient['name'] }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $patient['no_antrian'] ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-600 font-medium text-sm">{{ $patient['contact'] }}</td>
                        <td class="text-gray-600 text-sm truncate max-w-[150px]">{{ $patient['address'] }}</td>

                        <td class="text-gray-600 font-medium text-sm">
                            {{ \Carbon\Carbon::parse($patient['registered_at'])->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                     <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400">
                            Tidak ada data pasien yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
    // PERBAIKAN LOGIKA JS DI SINI, TRAINER!
    // Controller ngirim struktur: { labels: [...], values: [...], colors: [...] }
    // Jadi kita langsung ambil property-nya, JANGAN pakai Object.keys lagi.
    
     const chartConfig = @json($data['chart_pie']);
    
    console.log("Data Chart Masuk:", chartConfig);

    new Chart(document.getElementById('pieChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            // Kita langsung ambil dari properti JSON. JANGAN pakai Object.keys()
            labels: chartConfig.labels, 
            datasets: [{
                data: chartConfig.values, 
                backgroundColor: chartConfig.colors, 
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '0%', 
            plugins: {
                legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } }
            }
        }
    });
</script>

@endsection
