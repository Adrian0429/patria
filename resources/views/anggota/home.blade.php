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
    border:none;
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
    max-width: 200px;
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

/* General modal styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

/* Modal content */
.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: fadeIn 0.3s ease-in-out;
}

/* Modal heading */
.modal-content h3 {
    margin-bottom: 15px;
    font-size: 20px;
    font-weight: bold;
}

/* Form styling */
.modal-content .form-group {
    margin-bottom: 15px;
    text-align: left;
}

.modal-content label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.modal-content input,
.modal-content select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* Modal buttons */
.modal-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-danger {
    background: #dc3545;
    color: white;
}


/* Update the status badge styles */
.status-badge {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 500;
    text-align: center;
}

/* Table cell specific styling for status badge */
.table td.status-badge {

    display: table-cell;
    vertical-align: middle;
}

.text-status {
    padding: 4px 8px;
    border-radius: 20px;
    text-transform: capitalize;
}

.status-sudah {
    background-color: #d4edda;
    color: #155724;
}

.status-belum {
    background-color: #f8d7da;
    color: #721c24;
}


/* Modal animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
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

.search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

</style>
@extends('layouts.app')

@section('content')
<div class="main-container">

    <div class="top-button-container">
        @if (Auth::user()->jabatan != 'DPP' && Auth::user()->jabatan != 'DPC')
            <a href="{{ route('anggota.create') }}" class="btn-add-user">Tambahkan Anggota</a>
        @endif
        <p class="hidden"></p>
        <div class="search-container">  
            <a href="{{ route('download.dpd') }}" class="btn-add-user">Download List DPD</a>
            <a href="{{ route('download.dpc') }}" class="btn-add-user">Download List DPC</a>
            <a href="{{ route('download.csv') }}" class="btn-add-user">Download List Anggota</a>

            <form method="GET" action="{{ route('anggota.home') }}" style="margin: auto 0px;">
                <input type="text" name="search" placeholder="Cari berdasarkan nama, email, telp, nik, dpd/dpc"
                value="{{ request('search') }}" class="form-control" 
                style="width: 350px; padding: 12px; border-radius: 6px; border: 1px solid black;" />
            </form>
        </div>
        
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Kartu</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NomorHP</th>
                    <th>Kartu</th>
                    <th>Cabang/Daerah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggotas as $anggota)
                    <tr>
                        <td onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'">{{ $anggota->id }}</td>
                        <td onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'">{{ $anggota->ID_Kartu }}</td>
                        <td onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'">{{ $anggota->Nama_Lengkap }}</td>
                        <td onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'">{{ $anggota->Email }}</td>
                        <td onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'">{{ $anggota->No_HP }}</td>
                        <td class="status-badge" onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'"><p class="text-status {{ $anggota->Status_Kartu == 'sudah_cetak' ? 'status-sudah' : 'status-belum' }}">{{ str_replace('_', ' ', ucfirst($anggota->Status_Kartu)) }}</p></td>
                        <td onclick="window.location='{{ route('anggota.detail', $anggota->id) }}'">{{ $anggota->nama_dpd ?? $anggota->nama_dpc }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $anggotas->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $anggotas->previousPageUrl() }}">Previous</a>
            </li>
            @foreach ($anggotas->getUrlRange(1, $anggotas->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $anggotas->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
            <li class="page-item {{ $anggotas->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $anggotas->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this user?</p>
        <div class="modal-actions">
            <button id="cancelDelete" class="btn btn-secondary">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');

    function closeModal() {
        userModal.style.display = 'none';
        deleteModal.style.display = 'none';
    }

document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    const cancelDelete = document.getElementById('cancelDelete');

    function closeModal() {
        if (deleteModal) deleteModal.style.display = 'none';
    }

    if (cancelDelete) {
        cancelDelete.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside of the content
    deleteModal.addEventListener('click', function (event) {
        if (event.target === deleteModal) {
            closeModal();
        }
    });
});

</script>

@endsection
