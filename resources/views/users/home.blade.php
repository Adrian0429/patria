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



</style>
@extends('layouts.app')
<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this user?</p>
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

<div id="photoModal" class="modal">
    <div class="modal-content">
        <h3>Input Profil</h3>
        <div class="modal-actions">
            <form id="photoForm" method="POST" enctype="multipart/form-data" action="{{ route('users.uploadimage') }}">
                @csrf
                <input type="file" name="photos[]" multiple id="photos" class="form-control" required>
                <div class="photo-button">
                    <button type="submit" class="btn-add-user">Submit</button>
                    <button type="button" id="cancelButtonPhoto" class="btn-add-user-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('content')
<div class="main-container">

        <div class="top-button-container">
        <a href="{{ route('users.create') }}" class="btn-add-user">Tambahkan Anggota</a>

        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
        <form method="GET" action="{{ route('users.home') }}" style="display: flex;">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by name, email, or ID" 
                value="{{ request('search') }}" 
                class="form-control" 
                style="flex: 1; max-width: 300px; padding: 12px; border-radius: 6px; border: 1px solid black;" />
        </form>

        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'DPC')
            <a href="#" class="btn-add-user" onclick="openphotoModal('{{ route('users.uploadimage') }}')">Input Foto Profil</a>
        @endif

        </div>

        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Card ID</th>
                        <th>User ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Golongan Darah</th>
                        <th>Daerah</th>
                        <th>Vihara</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->card_id }}</td>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->jenis_kelamin }}</td>
                            <td>{{ $user->tanggal_lahir }}</td>
                            <td>{{ $user->golongan_darah }}</td>
                            <td>{{ $user->daerah }}</td>
                            <td>{{ $user->vihara }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('users.destroy', $user->user_id) }}')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1">Previous</a>
                </li>
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <script>

    const deleteModal = document.getElementById('deleteModal');
    const cancelButton = document.getElementById('cancelButtonPhoto');
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

    const photoModal = document.getElementById('photoModal');
    const cancelButtonPhoto = document.getElementById('cancelButtonPhoto');
    const photoForm = document.getElementById('photoForm');

    function openphotoModal(actionUrl) {
        photoForm.setAttribute('action', actionUrl);
        photoModal.style.display = 'flex'; // Show the modal
    }

    cancelButton.addEventListener('click', () => {
        photoModal.style.display = 'none'; // Hide the modal on cancel
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === photoModal) {
            photoModal.style.display = 'none';
        }
    });
</script>

@endsection

