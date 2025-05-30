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
                            class="border border-gray-300 rounded-md px-4 py-2 sm:w-1/3" style="width: 40%" />
                    </div>

                    <table id="alumniTable" class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase border-b border-t border-gray-500 ">
                            <tr>
                                <th class="px-4 py-4" rowspan="2">No</th>
                                <th class="px-4 py-4" rowspan="2">Nama</th>
                                <th class="px-4 py-4" rowspan="2">NIM</th>
                                <th class="px-4 py-4" rowspan="2">Program Studi</th>
                                <th class="px-4 py-4" rowspan="2">Email</th>
                                <th class="px-4 py-4 text-center border-b border-gray-500" colspan="3">Aksi</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-4">Show</th>
                                <th class="px-4 py-4">Edit</th>
                                <th class="px-4 py-4">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($alumni as $index => $alum)
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-6">{{ $alumni->firstItem() + $index }}</td>
                                    <td class="px-4 py-6">{{ $alum->nama }}</td>
                                    <td class="px-4 py-6">{{ $alum->nim }}</td>
                                    <td class="px-4 py-6">{{ $alum->programStudi->nama_prodi }}</td>
                                    <td class="px-4 py-6">{{ $alum->email }}</td>
                                    <td class="px-4 py-6 text-center">
                                        <a href="javascript:void(0)" onclick="openShowModal({{ $alum->alumni_id }})"
                                            class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <a href="javascript:void(0)" onclick="openEditModal({{ $alum->alumni_id }})"
                                            class="text-yellow-600 hover:text-yellow-900"><i
                                                class="fas fa-pen-to-square"></i></a>
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <form action="{{ route('alumni.destroy', $alum->alumni_id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini?')"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                style="background: none; border: none;"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 px-4">
                        {{ $alumni->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('alumni.show-modal')
    @include('alumni.edit-modal')
    <script src="{{ asset('assets/js/data-alumni.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const table = document.getElementById("alumniTable");
            const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            searchInput.addEventListener("keyup", function() {
                const keyword = this.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    let rowText = rows[i].textContent.toLowerCase();
                    if (rowText.includes(keyword)) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            });
        });
    </script>
</x-app-layout>
