<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight whitespace-nowrap">
                {{ __('Data Alumni') }}
            </h2>
            <x-filter/>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="width: 100%">
                <h2 class="font-semibold text-gray-700 mb-4 text-center">Data Alumni Tersedia
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-4" rowspan="2">No</th>
                                <th class="px-4 py-4" rowspan="2">Nama</th>
                                <th class="px-4 py-4" rowspan="2">Program Studi</th>
                                <th class="px-4 py-4" rowspan="2">No HP</th>
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
