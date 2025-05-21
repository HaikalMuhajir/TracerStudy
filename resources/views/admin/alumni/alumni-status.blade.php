{{-- @if($alumni->status == 'Belum Mengisi')
    <span class="badge bg-secondary">Belum Mengisi</span>
@elseif($alumni->status == 'Ditinjau')
    <div class="dropdown">
        <button class="btn btn-warning dropdown-toggle" type="button" 
                data-bs-toggle="dropdown" aria-expanded="false">
            Ditinjau
        </button>
        <ul class="dropdown-menu">
            <li>
                <button type="button" class="dropdown-item text-success update-status"
                        data-id="{{ $alumni->alumni_id }}"
                        data-status="Sudah Mengisi">
                    <i class="fas fa-check me-2"></i>Setujui
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item text-danger update-status"
                        data-id="{{ $alumni->alumni_id }}"
                        data-status="Ditolak">
                    <i class="fas fa-times me-2"></i>Tolak
                </button>
            </li>
        </ul>
    </div>
@elseif($alumni->status == 'Sudah Mengisi')
    <span class="badge bg-success">Sudah Mengisi</span>
@else
    <span class="badge bg-danger">Ditolak</span>
@endif --}}
