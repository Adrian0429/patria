<style>
.main-container {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 84px); 
    box-sizing: border-box;
    padding: 0px 20px 20px 20px;
}

.judul-event { 
    margin: 10px 0px;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}
.table-responsive {
    overflow-y: auto; 
    flex-grow: 1; /* Allow it to take remaining space naturally */
    display: flex;
    flex-direction: column;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    margin-bottom: 12px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.table tbody {
    flex-grow: 1;
    display: table-row-group; /* Keep natural row structure */
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
    font-size: 1rem;
    border-radius: 6px;
    text-decoration: none;
    min-width: 110px;
    color: #fff;
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

.btn-add-event {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 20px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    color: #fff;
    background-color: #007bff;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
    max-width: 200px;
}

.btn-add-event:hover {
    background-color: #0056b3;
    transform: translateY(-2px); 
}

.btn-add-event:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5); /* Focus ring */
}

.table td:last-child {
    display: flex;
    height: 100%;
    flex-direction: column;
    justify-content: center; /* Center buttons vertically */
    align-items: center; /* Center buttons horizontally */
    min-width: 150px; /* Ensure enough space for the buttons */
}

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

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.modal-actions {
    margin-top: 20px;
    display: flex;
    justify-content: space-around;
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

</style>
@extends('layouts.app')
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this attendance?</p>
        <div class="modal-actions">
            <button id="cancelButton" class="btn btn-secondary">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@section('content')
<div class="main-container">
            
    <h1 class="judul-event">Daftar Absensi : {{ $event->name }}</h1>
    <a href="{{ route('attendance.download', $event->id) }}" class="btn-add-event">
        Download CSV
    </a>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Email Anggota</th>
                    <th>Tanggal Absen</th>
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->id }}</td>
                        <td>{{ $attendance->nama_anggota }}</td>
                        <td>{{ $attendance->email_anggota }}</td>
                        <td>{{ $attendance->created_at }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('attendance.delete', $attendance->id) }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $attendances->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $attendances->previousPageUrl() }}" tabindex="-1">Previous</a>
                </li>
                @foreach ($attendances->getUrlRange(1, $attendances->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $attendances->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="page-item {{ $attendances->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $attendances->nextPageUrl() }}">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <script>
    const deleteModal = document.getElementById('deleteModal');
    const cancelButton = document.getElementById('cancelButton');
    const deleteForm = document.getElementById('deleteForm');

    function openDeleteModal(actionUrl) {
        deleteForm.setAttribute('action', actionUrl);
        deleteModal.style.display = 'flex'; // Show the modal
    }

    cancelButton.addEventListener('click', () => {
        deleteModal.style.display = 'none'; // Hide the modal on cancel
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
</script>

@endsection

