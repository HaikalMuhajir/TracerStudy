<form id="filter-form" method="POST" action="{{ route('filter.set') }}" class="flex flex-wrap items-center"
    style="margin-bottom: 0; margin-top:0">
    @csrf
    <select name="prodi" id="prodi_header" style="margin-right: 8px;"
        class="border-gray-300 text-sm rounded-md shadow-sm">
        <option value="">Semua Prodi</option>
        <option value="1" {{ session('filter.prodi') == '1' ? 'selected' : '' }}>D4 Teknik Informatika</option>
        <option value="2" {{ session('filter.prodi') == '2' ? 'selected' : '' }}>D4 Sistem Informasi Bisnis</option>
        <option value="3" {{ session('filter.prodi') == '3' ? 'selected' : '' }}>D2 PPLS</option>
        <option value="4" {{ session('filter.prodi') == '4' ? 'selected' : '' }}>S2 MRTI</option>


    </select>

    <select name="tahun_awal" id="tahun_awal_header" style="margin-right: 8px;"
        class="border-gray-300 text-sm rounded-md shadow-sm">
        <option value="" disabled {{ request('tahun_awal') ? '' : 'selected' }}>Tahun Awal</option>
        @for ($year = 2020; $year <= 2025; $year++)
            <option value="{{ $year }}" {{ session('filter.tahun_awal') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor
    </select>

    <select name="tahun_akhir" id="tahun_akhir_header" style="margin-right: 8px;"
        class="border-gray-300 text-sm rounded-md shadow-sm">
        <option value="" disabled {{ request('tahun_akhir') ? '' : 'selected' }}>Tahun Akhir</option>
        @for ($year = 2020; $year <= 2025; $year++)
            <option value="{{ $year }}" {{ session('filter.tahun_akhir') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor
    </select>

    <x-primary-button class="whitespace-nowrap">
        Filter
    </x-primary-button>
</form>
