<style>
.main-container {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 84px);
    box-sizing: border-box;
    padding: 0 20px 20px 20px;
}

.table-responsive {
    height: calc(100vh - 84px);
    overflow-y: auto; 
}

.table {
    flex: 1;
    width: 100%;
    height: 80%;
    border-collapse: collapse;
    background-color: #fff;
    margin-bottom: 12px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

}

.table th, .table td {
    padding: 6px 7px;
    border-bottom: 1px solid #ddd;
    font-size: 0.95rem;
    text-align: center;
    word-wrap: break-word; /* Ensures text wraps within the cell */
}

.table th {
    position: sticky; /* Makes the header sticky */
    top: 0; /* Stick to the top of the container */
    background-color: #f4f4f4; /* Sticky header background */
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
    z-index: 1; /* Ensures it stays above table rows */
}

.table tr:hover {
    background-color: #f9f9f9;
}

.pagination {
    margin-top: 10px;
    justify-content: center;
    display: flex;
    list-style: none;
    padding-left: 0;
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-link {
    padding: 8px 16px;
    font-size: 0.9rem;
    color: #007bff;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    text-decoration: none;
    transition: background-color 0.3s, border-color 0.3s;
}

.pagination .page-link:hover {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    text-decoration: none;
}

.pagination .active .page-link {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination .disabled .page-link {
    color: #ccc;
    pointer-events: none;
    background-color: #f8f9fa;
    border-color: #ddd;
}


/* Buttons */
.btn {
    padding: 6px 12px;
    font-size: 0.9rem;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    border: none;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-info {
    background-color: #17a2b8;
}

.btn-info:hover {
    background-color: #117a8b;
}

.btn-warning {
    background-color: #ffc107;
}

.btn-warning:hover {
    background-color: #d39e00;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-danger:hover {
    background-color: #bd2130;
}

.btn-add-user {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 20px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    color: #fff;
    background-color: #007bff;
    border-radius: 6px;
    border: none;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
    max-width: 200px;
}

.btn-add-user:hover {
    background-color: #0056b3;
    transform: translateY(-2px); 
}


.btn-add-user-cancel {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 20px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    color: #fff;
    background-color: #dc3545;
    border-radius: 6px;
    border: none;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
    max-width: 250px;
}

.btn-add-user-cancel:hover {
    background-color: #bd2130;
    transform: translateY(-2px); 
}


.btn-add-user:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5); /* Focus ring */
}

.table td:last-child {
    min-width: 200px; /* Adjust this value to provide enough space for the buttons */
    text-align: center;
}


  /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #fff;
        padding: 20px;
        width: 400px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .modal-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .form-group {
        text-align: left;
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

.modal .btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    font-size: 0.9rem;
    cursor: pointer;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-danger:hover {
    background-color: #bd2130;
}

.top-button-container {
    padding: 12px 0;
    display: flex;
    justify-content: space-between;
}

/* Style for the file input */
#photos {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #f8f8f8;
    cursor: pointer;
    margin-bottom: 10px;
    transition: border-color 0.3s ease;
}

#photos:hover {
    border-color: #4CAF50;
}

/* Style for the p tag displaying selected file count */
#fileCount {
    font-size: 14px;
    color: #333;
    margin-top: 5px;
}

.photo-button {
    display: flex;
    justify-content: space-between;
}   



</style>
@extends('layouts.app')

@section('content')
<div class="main-container">

    <div class="top-button-container">
        @if (Auth::User()->jabatan == 'admin')
           <button class="btn-add-user" onclick="openCreateModal()">Tambahkan Cabang DPC</button>
        @endif
        
        <form method="GET" action="{{ route('users.index_dpc') }}" style="margin: auto 0px;">
            <input type="text" name="search" placeholder="Cari disini"
            value="{{ request('search') }}" class="form-control" 
            style="min-width:300px; max-width: 500px; padding: 12px; border-radius: 6px; border: 1px solid black;" />
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Nama DPC</th>
                    <th>DPD</th>
                    <th>Kode Daerah</th>
                    @if (Auth::User()->jabatan == 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($dpcs as $dpc)
                    <tr>
                        {{-- <td>{{ $dpc->id }}</td> --}}
                        <td>{{ $dpc->nama_dpc }}</td>
                        <td>{{ $dpc->dpd->nama_dpd }}</td>
                        <td>{{ $dpc->kode_daerah }}</td>
                        @if  (Auth::User()->jabatan == 'admin')
                        <td>
                            <button class="btn btn-warning btn-sm" 
                                onclick="openEditModal({{ $dpc->id }}, '{{ $dpc->dpd_id }}', '{{ $dpc->nama_dpc }}', '{{ $dpc->kode_daerah }}')">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('users.destroy', $dpc->id) }}')">Delete</button>
                        </td>
                        @endif
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $dpcs->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $dpcs->previousPageUrl() }}">Previous</a>
            </li>
            @foreach ($dpcs->getUrlRange(1, $dpcs->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $dpcs->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
            <li class="page-item {{ $dpcs->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $dpcs->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
</div>

{{-- create modal --}}
<div id="createModal" class="modal">
    <div class="modal-content">
        <h3 class="modal-title">Tambah DPC</h3>
        <form id="createForm" method="POST" action="{{ route('users.store_dpc') }}">
            @csrf
            <div class="form-group">
                <label for="dpd_id">DPD</label>
                <select id="dpd_id" name="dpd_id" class="form-control" required>
                    <option value="">Pilih DPD</option>
                    @foreach ($dpds as $dpd)
                        <option value="{{ $dpd->id }}">{{ $dpd->nama_dpd }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_dpc">Nama DPC</label>
                <input type="text" id="nama_dpc" name="nama_dpc" class="form-control" placeholder="Masukkan nama DPC" required>
            </div>
            <div class="form-group">
                <label for="kode_daerah">Kode Daerah</label>
                <input type="text" id="kode_daerah" name="kode_daerah" class="form-control" placeholder="Masukkan kode daerah" required>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit DPC</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editDpcId" name="id">

            <div class="form-group">
                <label for="editDpdId">DPD</label>
                <select id="editDpdId" name="dpd_id" class="form-control" required>
                    <option value="">Pilih DPD</option>
                    @foreach ($dpds as $dpd)
                        <option value="{{ $dpd->id }}" 
                            @if(old('dpd_id', $dpc->dpd_id ?? '') == $dpd->id) selected @endif>
                            {{ $dpd->nama_dpd }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="editNamaDpc">Nama DPC</label>
                <input value="{{ $dpc->nama_dpc }}" type="text" id="editNamaDpc" name="nama_dpc" placeholder="Nama DPC" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editKodeDaerah">Kode Daerah</label>
                <input value="{{ $dpc->kode_daerah }}" type="text" id="editKodeDaerah" name="kode_daerah" placeholder="Kode Daerah" class="form-control" required>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
            </div>
        </form>
    </div>
</div>


<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3 class="modal-title">Konfirmasi Hapus</h3>
        <p>Anda yakin ingin menghapus DPC ini?</p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button onclick="openDeleteModal({{ $dpc->id }})" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>


<script>
function openCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

function openEditModal(id, dpd_id, nama_dpc, kode_daerah) {
    document.getElementById('editDpcId').value = id;
    
    // Ensure the correct DPD option is selected
    let dpdSelect = document.getElementById('editDpdId');
    for (let option of dpdSelect.options) {
        if (option.value == dpd_id) {
            option.selected = true;
        }
    }

    document.getElementById('editNamaDpc').value = nama_dpc;
    document.getElementById('editKodeDaerah').value = kode_daerah;
    
    document.getElementById('editForm').setAttribute('action', `/dpc/update/${id}`);
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function openDeleteModal(id) {
    document.getElementById('deleteForm').setAttribute('action', `/dpc/destroy/${id}`);
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

window.addEventListener('click', (event) => {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

</script>
@endsection



