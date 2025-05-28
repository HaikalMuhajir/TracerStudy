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

                    {{-- Spacer kanan agar judul tetap di tengah meski tidak ada konten di kanan --}}
                    <div style="width: 100px"></div>
                </div>

                <div class="overflow-x-auto">
                    <table id="alumniTable" class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase border-b border-t border-gray-200 ">
                            <tr>
                                <th class="px-4 py-4" rowspan="2">No</th>
                                <th class="px-4 py-4" rowspan="2">Nama</th>
                                <th class="px-4 py-4" rowspan="2">NIM</th>
                                <th class="px-4 py-4" rowspan="2">Program Studi</th>
                                <th class="px-4 py-4" rowspan="2">Email</th>
                                <th class="px-4 py-4 text-center border-b border-gray-200" colspan="3">Aksi</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-4">Show</th>
                                <th class="px-4 py-4">Edit</th>
                                <th class="px-4 py-4">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($alumni as $index => $alum)
                                <tr>
                                    <td class="px-4 py-4">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">{{ $alum->nama }}</td>
                                    <td class="px-4 py-4">{{ $alum->nim }}</td>
                                    <td class="px-4 py-4">{{ $alum->programStudi->nama_prodi }}</td>
                                    <td class="px-4 py-4">{{ $alum->email }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="javascript:void(0)" onclick="openShowModal({{ $alum->alumni_id }})"
                                            class="text-blue-600 hover:text-blue-900" style="line-height: 1;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="javascript:void(0)" onclick="openEditModal({{ $alum->alumni_id }})"
                                            class="text-yellow-600 hover:text-yellow-900" style="line-height: 1;">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="{{ route('alumni.destroy', $alum->alumni_id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini?')"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                style="background: none; border: none; padding: 0; line-height: 1; cursor: pointer;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('alumni.show-modal')
    @include('alumni.edit-modal')
    <script src="{{ asset('assets/js/data-alumni.js') }}"></script>
</x-app-layout>
