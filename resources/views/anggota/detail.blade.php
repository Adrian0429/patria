<style>
.detail-container {
    display: flex;
    flex-direction: column;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.detail-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
}

.detail-back-button {
    padding: 8px 16px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.detail-back-button:hover {
    background-color: #5a6268;
}

.detail-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 24px;
    margin-bottom: 24px;
}

.detail-section {
    margin-bottom: 32px;
}

.detail-section-title {
    font-size: 1.6rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f0f0f0;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.detail-item {
    margin-bottom: 16px;
}

.detail-label {
    font-weight: 600;
    color: #666;
    margin-bottom: 4px;
    font-size: 1.2rem;
}

.detail-value {
    color: #333;
    font-size: 1rem;
}

.detail-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
}

.btn-edit {
    background-color: #ffc107;
    color: #000;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-edit:hover {
    background-color: #d39e00;
}

.btn-delete:hover {
    background-color: #bd2130;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-sudah {
    background-color: #d4edda;
    color: #155724;
}

.status-belum {
    background-color: #f8d7da;
    color: #721c24;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 24px;
    border-radius: 12px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

.modal h3 {
    margin: 0 0 16px 0;
    font-size: 1.25rem;
    color: #333;
}

.modal p {
    margin: 0 0 24px 0;
    color: #666;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}
</style>

@extends('layouts.app')

@section('content')
<div class="detail-container">
    <div class="detail-header">
        <h1 class="detail-title">Detail Anggota</h1>
        <a href="{{ route('anggota.home') }}" class="detail-back-button">
            Kembali
        </a>
    </div>

    <div class="detail-card">
        <div class="detail-section">
            <h2 class="detail-section-title">Informasi Pribadi</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">ID Anggota</div>
                    <div class="detail-value">{{ $anggota->id }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">ID Kartu</div>
                    <div class="detail-value">{{ $anggota->ID_Kartu }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">NIK</div>
                    <div class="detail-value">{{ $anggota->NIK }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">{{ $anggota->Nama_Lengkap }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nama Buddhis</div>
                    <div class="detail-value">{{ $anggota->Nama_Buddhis ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Jenis Kelamin</div>
                    <div class="detail-value">{{ $anggota->Jenis_Kelamin }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tempat, Tanggal Lahir</div>
                    <div class="detail-value">{{ $anggota->Kota_Lahir }}, {{ \Carbon\Carbon::parse($anggota->Tanggal_Lahir)->format('d F Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Golongan Darah</div>
                    <div class="detail-value">{{ $anggota->Golongan_Darah ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Gelar Akademis</div>
                    <div class="detail-value">{{ $anggota->Gelar_Akademis ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Profesi</div>
                    <div class="detail-value">{{ $anggota->Profesi ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2 class="detail-section-title">Kontak & Alamat</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $anggota->Email }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nomor HP</div>
                    <div class="detail-value">{{ $anggota->No_HP }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Alamat</div>
                    <div class="detail-value">{{ $anggota->Alamat }}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2 class="detail-section-title">Informasi Keanggotaan</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Status Kartu</div>
                    <div class="detail-value">
                        <span class="status-badge {{ $anggota->Status_Kartu == 'sudah_cetak' ? 'status-sudah' : 'status-belum' }}">
                            {{ str_replace('_', ' ', ucfirst($anggota->Status_Kartu)) }}
                        </span>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Cabang/Daerah</div>
                    <div class="detail-value">{{ $anggota->nama_dpd ?? $anggota->nama_dpc }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Mengenal Patria Dari</div>
                    <div class="detail-value">{{ $anggota->Mengenal_Patria_Dari ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Histori Patria</div>
                    <div class="detail-value">{{ $anggota->Histori_Patria ?? '-' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Pernah Mengikuti PBT</div>
                    <div class="detail-value">{{ $anggota->Pernah_Mengikuti_PBT ? 'Ya' : 'Tidak' }}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h2 class="detail-section-title">Foto Anggota</h2>
            @if($anggota->img_link && file_exists(public_path('storage/' . $anggota->img_link)))
            <img src="{{ asset('storage/' . $anggota->img_link) }}" alt="KTP {{ $anggota->Nama_Lengkap }}" style="max-width: 100%; height: auto; border-radius: 8px;">
            @else
            <p>Tidak ada foto yang tersedia</p>
            @endif
        </div>

        <div class="detail-actions">
            <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-edit">
                Edit Data
            </a>
            <button class="btn btn-delete" onclick="openDeleteModal('{{ route('anggota.destroy', $anggota->id) }}')">
                Hapus Anggota
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Konfirmasi Penghapusan</h3>
        <p>Apakah Anda yakin ingin menghapus anggota ini?</p>
        <div class="modal-actions">
            <button id="cancelDelete" class="btn btn-secondary">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Hapus</button>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("deleteModal");
    const deleteForm = document.getElementById("deleteForm");
    const cancelButton = document.getElementById("cancelDelete");

    function closeDeleteModal() {
        modal.style.display = "none";
    }

    function openDeleteModal(deleteUrl) {
        deleteForm.action = deleteUrl;
        modal.style.display = "flex";
    }

    // Ensure the cancel button closes the modal
    cancelButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent any unintended behavior
        closeDeleteModal();
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeDeleteModal();
        }
    });

    // Make the function available globally
    window.openDeleteModal = openDeleteModal;
});

</script>

@endsection 