@extends('layouts.sidebar')
@section('title', 'Dashboard Admin')
@section('content')

<div class="flex flex-col md:flex-row gap-4 mb-8 items-stretch">
    <div class="flex-1 bg-linear-to-b from-brand-secondary to-[#81E1DD] text-white px-6 py-4 rounded-xl shadow-md flex items-center">
        <h2 class="text-xl md:text-2xl font-bold tracking-wide">
            Selamat Datang, {{ explode(' ', $data['profile']['name'])[0] }}! Semangat Kerja!
        </h2>
    </div>
</div>

{{-- STATISTICS CARDS --}}
<div class="grid gap-6 mb-8 items-stretch">
    <div class="flex gap-6 h-full">
        {{-- KARTU 1 --}}
        <div class="bg-white p-6 rounded-xl shadow-sm text-center flex-1 flex flex-col justify-center">
            <h3 class="text-4xl font-bold text-brand-secondary">{{ $data['stats']['registered_patients'] }}</h3>
            <p class="text-brand-secondary font-medium mt-1">Total Pasien Terdaftar</p>
        </div>

        {{-- KARTU 2 --}}
        <div class="bg-white p-6 rounded-xl shadow-sm text-center flex-1 flex flex-col justify-center">
            <h3 class="text-4xl font-bold text-brand-secondary">{{ $data['stats']['new_patients'] }}</h3>
            <p class="text-brand-secondary font-medium mt-1">Kunjungan Bulan Ini</p>
        </div>
    </div>
</div>

{{-- SECTION CHART --}}
<div class="bg-white p-6 rounded-xl shadow-sm mb-8">
    <div class="bg-linear-to-b from-brand-secondary to-[#81E1DD] text-white px-4 py-2 rounded-t-lg -mt-6 -mx-6 mb-4 flex justify-between items-center">
        <h3 class="font-bold">Statistik Kunjungan per Klinik</h3>
        
        {{-- FORM FILTER CHART --}}
        <form action="{{ route('admin.dashboard') }}" method="GET">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            @if(request('month_table')) <input type="hidden" name="month_table" value="{{ request('month_table') }}"> @endif
            
            <select name="month" onchange="this.form.submit()" class="bg-white/20 text-white text-sm border-none rounded focus:ring-0 cursor-pointer font-bold">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" class="text-black bg-white" style="color: black;" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                        Chart: {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="h-64 w-full relative">
        <canvas id="pieChart"></canvas>
    </div>
</div>

{{-- SECTION TABEL DATA PASIEN --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

    <div class="bg-linear-to-b from-brand-secondary to-[#81E1DD] px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <h3 class="text-white font-bold text-lg tracking-wide">Data Pasien Terdaftar</h3>

        {{-- FORM FILTER & SEARCH --}}
        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto items-center">
            @if(request('month')) <input type="hidden" name="month" value="{{ request('month') }}"> @endif

            <div class="relative">
                <select name="month_table" onchange="this.form.submit()" 
                    class="appearance-none py-2 pl-4 pr-10 rounded text-sm bg-white/20 text-white font-bold focus:outline-none focus:ring-0 border-none cursor-pointer">
                    <option value="" class="text-black bg-white" style="color: black;" {{ request('month_table') == '' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" class="text-black bg-white" style="color: black;" {{ request('month_table') == $m ? 'selected' : '' }}>
                            Daftar: {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="relative w-full md:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIK..."
                    class="w-full pl-4 pr-10 py-2 rounded-full text-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-200 shadow-sm" />
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-teal-50 text-teal-600 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="py-4 pl-6 text-left">Nama Lengkap</th>
                    <th class="text-left">NIK / ID</th>
                    <th class="text-left">Kontak</th>
                    <th class="text-left">Alamat</th>
                    <th class="text-left">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            {{-- PERBAIKAN: Gunakan ['table_data'] bukan ['reservations'] --}}
            @forelse ($data['table_data'] as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="pl-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="avatar placeholder">
                                <div class="{{ $item['color'] }} rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm shadow-sm">
                                    <span>{{ $item['initial'] }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $item['name'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-gray-600 font-mono text-sm">{{ $item['nik'] }}</td>
                    <td class="text-gray-600 font-medium text-sm">{{ $item['contact'] }}</td>
                    <td class="text-gray-600 text-sm truncate max-w-[150px]">{{ $item['address'] }}</td>
                    <td class="text-gray-600 font-medium text-sm">
                        {{ \Carbon\Carbon::parse($item['registered_at'])->format('d M Y') }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-8 text-gray-400">Belum ada pasien terdaftar.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION (Perbaikan Variabel di sini juga) --}}
    @if ($data['table_data']->hasPages())
    <div class="px-6 py-4 flex justify-center items-center border-t border-gray-100 bg-white">
        <div class="flex items-center gap-2 select-none">
            @if ($data['table_data']->onFirstPage())
                <span class="text-gray-400 cursor-not-allowed text-sm">Previous</span>
            @else
                <a href="{{ $data['table_data']->previousPageUrl() }}" class="text-brand-secondary hover:underline text-sm font-medium">Previous</a>
            @endif
            <div class="flex items-center mx-2 gap-1">
                @foreach ($data['table_data']->onEachSide(1)->links()->elements as $element)
                    @if (is_string($element)) <span class="px-2 text-gray-500 text-sm">{{ $element }}</span> @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $data['table_data']->currentPage())
                                <span class="text-[#388e72] font-bold text-sm px-2 cursor-default">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="text-brand-secondary hover:underline hover:text-[#388e72] text-sm px-2">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            @if ($data['table_data']->hasMorePages())
                <a href="{{ $data['table_data']->nextPageUrl() }}" class="text-brand-secondary hover:underline text-sm font-medium">Next</a>
            @else
                <span class="text-gray-400 cursor-not-allowed text-sm">Next</span>
            @endif
        </div>
    </div>
    @endif
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
