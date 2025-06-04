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
                        class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-pen-to-square"></i></a>
                </td>
                <td class="px-4 py-6 text-center">
                    <form action="{{ route('alumni.destroy', $alum->alumni_id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini?')"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900"
                            style="background: none; border: none;"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-4 px-4">
    {{ $alumni->links() }}
</div>
