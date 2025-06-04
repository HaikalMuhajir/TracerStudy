<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                {{ __('Data Alumni') }}
            </h2>
            <x-filter />
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                <div class="flex justify-between items-center mb-4 px-4">
                    {{-- Tombol Import di kiri --}}
                    <form id="importForm" action="{{ route('alumni.import') }}" method="POST"
                        enctype="multipart/form-data" class="flex-shrink-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" accept=".xls,.xlsx" class="hidden" required
                            onchange="document.getElementById('importForm').submit();" />
                        <x-primary-button type="button" onclick="document.getElementById('fileInput').click();">
                            Import
                        </x-primary-button>
                        @if (session('success'))
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: '{{ session('success') }}',
                                    confirmButtonText: 'OK'
                                });
                            </script>
                        @endif
                    </form>

                    {{-- Judul di tengah secara visual --}}
                    <div class="flex-1 text-center">
                        <h2 class="text-lg font-semibold text-gray-700">
                            Data Alumni Tersedia
                        </h2>
                    </div>

                    <a href="{{ route('export.all') }}">
                        <x-primary-button>
                            Export
                        </x-primary-button>
                    </a>

                </div>

                <div class="overflow-x-auto">
                    <div class="mb-4 px-4">
                        <input type="text" id="searchInput" placeholder="Cari alumni berdasarkan nama atau NIM..."
                            class="border border-gray-300 rounded-md px-4 py-2 sm:w-1/3" style="width: 31%" />
                    </div>
                    <div id="alumniTableWrapper">
                        @include('alumni._table', ['alumni' => $alumni])
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('alumni.show-modal')
    @include('alumni.edit-modal')
    <script src="{{ asset('assets/js/data-alumni.js') }}"></script>
</x-app-layout>
