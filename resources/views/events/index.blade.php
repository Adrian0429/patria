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
    border-collapse: collapse;
    background-color: #fff;
    margin-bottom: 12px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}


.table th, .table td {
    padding: 10px 10px;
    font-size: 0.95rem;
    text-align: center;
    word-wrap: break-word; 
}

.table td {
    height: 100px;
}

.table th {
    position: sticky; /* Makes the header sticky */
    top: 0;
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


/* General Button Styles */
.btn {
    display: inline-block;
    padding: 6px 12px;
    font-size: 1rem;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    min-width: 120px; /* Ensure equal width for buttons */
    color: #fff;
    transition: all 0.3s;
}

.btn-sm {
    font-size: 0.85rem;
    padding: 5px 10px;
}

/* Button Colors */
.btn-info {
    background-color: #17a2b8;
    border: none;
}

.btn-info:hover {
    background-color: #117a8b;
}

.btn-warning {
    background-color: #ffc107;
    border: none;
}

.btn-warning:hover {
    background-color: #d39e00;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.btn-danger:hover {
    background-color: #bd2130;
}

.table td:last-child {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
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


.table td:last-child {
    display: flex;
    flex-direction: column; 
    justify-content: center; 
    align-items: center; 
    gap: 10px;
    height: 100%;
}


</style>
@extends('layouts.app')
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this event?</p>
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

    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
        <a href="{{ route('events.createEventForm') }}" class="btn-add-event">Tambahkan Event</a>
        <form method="GET" action="{{ route('events.index') }}" style="display: flex;">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by event name" 
                value="{{ request('search') }}" 
                class="form-control" 
                style="flex: 1; max-width: 300px; padding: 12px; border-radius: 6px; border: 1px solid black;" />
        </form>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Nama Event</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Daerah</th>
                    <th>Pembuat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->id_anggota }}</td>
                        <td>{{ $event->nama_event }}</td>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td>
                            @if ($event->nama_dpd)
                                {{ $event->nama_dpd }} (DPD)
                            @elseif ($event->nama_dpc)
                                {{ $event->nama_dpc }} (DPC)
                            @else
                                Pusat
                            @endif
                        </td>
                        <td>{{ $event->nama }}</td>
                         <!-- Directly use users.nama from the join -->
                        <td>
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <a href="{{ route('events.attend', $event->id) }}" class="btn btn-info btn-sm">Absen</a>
                                <a href="{{ route('attendance.index', $event->id) }}" class="btn btn-info btn-sm">Daftar Absen</a>
                            </div>
                            @if (Auth::user()->id == $event->user_id)
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('events.delete', $event->id) }}')">Delete</a>
                            </div>       
                            @endif                     
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $events->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $events->previousPageUrl() }}" tabindex="-1">Previous</a>
                </li>
                @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $events->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="page-item {{ $events->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $events->nextPageUrl() }}">Next</a>
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

