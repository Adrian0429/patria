<style>
    .main-container {
    display: flex;
    flex-direction: column;
    margin: 20px 20px;
    }

.table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    text-align: left;
    margin-top: 20px;
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
    background-color: #f4f4f4;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
}

.table td:last-child {
    min-width: 200px; /* Adjust this value to provide enough space for the buttons */
    text-align: center;
}


.table tr:hover {
    background-color: #f9f9f9;
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

/* Pagination */
.pagination {
    margin-top: 20px;
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

.pagination .page-item:first-child .page-link {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.pagination .page-item:last-child .page-link {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.btn-add-user {
    display: inline-block;
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

.btn-add-user:hover {
    background-color: #0056b3;
    transform: translateY(-2px); /* Slight lift effect on hover */
}

.btn-add-user:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5); /* Focus ring */
}

</style>
@extends('layouts.app')
@section('content')
    <div class="main-container">
        <!-- Add button to redirect to the create user page -->
        <a href="{{ route('users.create') }}" class="btn-add-user">Tambahkan Anggota</a>
        
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
                            <td>{{ $user->vihara }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
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
@endsection
