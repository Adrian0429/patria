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



</style>
@extends('layouts.app')

@section('content')
<div class="main-container">

    <div class="top-button-container">
        <button class="btn-add-user" onclick="openUserModal()">Tambahkan Anggota</button>
        
        <form method="GET" action="{{ route('users.home') }}" style="margin: auto 0px;">
            <input type="text" name="search" placeholder="Cari berdasarkan nama atau email"
            value="{{ request('search') }}" class="form-control" 
            style="max-width: 300px; padding: 12px; border-radius: 6px; border: 1px solid black;" />
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Akun</th>
                    <th>Email</th>
                    <th>Jabatan Akun</th>
                    <th>Cabang/Daerah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->jabatan }}</td>
                        <td>{{ $user->nama_dpd ?? $user->nama_dpc ?? 'Pusat' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal({{ json_encode($user) }})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ route('users.destroy', $user->id) }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
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

<!-- User Form Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <h3 id="modalTitle">Tambah Anggota</h3>
        <form id="userForm" method="POST">
            @csrf
            <input type="hidden" id="userId" name="id">
            <div id="methodField"></div> <!-- Placeholder for method override -->

            <div class="form-group">
                <label for="nama">Nama Akun:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email Akun:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <select id="jabatan" name="jabatan" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="DPP">DPP</option>
                    <option value="DPD">DPD</option>
                    <option value="DPC">DPC</option>
                    <option value="DPAC">DPAC</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dpd_id">Cabang/Daerah:</label>
                <select id="dpd_id" name="dpd_id" class="form-control">
                    <option value="">-- Pilih DPD --</option>
                    @foreach($dpds as $dpd)
                        <option value="{{ $dpd->id }}">{{ $dpd->nama_dpd }}</option>
                    @endforeach
                </select>

                <select id="dpc_id" name="dpc_id" class="form-control" style="margin-top: 12px;">
                    <option value="">-- Pilih DPC --</option>
                    @foreach($dpcs as $dpc)
                        <option value="{{ $dpc->id }}">{{ $dpc->nama_dpc }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
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

document.addEventListener("DOMContentLoaded", function () {
    const jabatanSelect = document.getElementById("jabatan");
    const dpdSelect = document.getElementById("dpd_id");
    const dpcSelect = document.getElementById("dpc_id");

    const userModal = document.getElementById('userModal');
    const deleteModal = document.getElementById('deleteModal');
    const userForm = document.getElementById('userForm');
    const deleteForm = document.getElementById('deleteForm');

    function enforceSingleSelection() {
        dpdSelect.addEventListener("change", function () {
            if (this.value) {
                dpcSelect.value = ""; // Clear DPC if DPD is selected
            }
        });

        dpcSelect.addEventListener("change", function () {
            if (this.value) {
                dpdSelect.value = ""; // Clear DPD if DPC is selected
            }
        });
    }

    function toggleDpdDpcFields() {
        const jabatanValue = jabatanSelect.value;

        if (jabatanValue === "DPP") {
            dpdSelect.value = "";
            dpcSelect.value = "";
            dpdSelect.style.display = "none";
            dpcSelect.style.display = "none";

        } else {
            dpdSelect.style.display = "block";
            dpcSelect.style.display = "block";
        }
    }

    // Attach event listeners
    enforceSingleSelection();
    jabatanSelect.addEventListener("change", toggleDpdDpcFields);

    function initializeModal() {
        enforceSingleSelection();  // Ensure event listeners are set
        toggleDpdDpcFields(); // Set correct state for fields
    }

    window.openUserModal = function () {
        console.log("Opening user modal..."); // Debugging log
        document.getElementById('modalTitle').innerText = 'Tambahkan Anggota';
        userForm.setAttribute('action', "{{ route('users.store') }}");
        userForm.reset();
        initializeModal();  
        userModal.style.display = 'flex';
    };

    window.openEditModal = function (user) {
        console.log("Opening edit modal for:", user); // Debugging log
        document.getElementById('modalTitle').innerText = 'Edit Anggota';
        userForm.setAttribute('action', `/users/edit/${user.id}`);
        document.getElementById('userId').value = user.id;
        document.getElementById('nama').value = user.nama;
        document.getElementById('email').value = user.email;
        document.getElementById('jabatan').value = user.jabatan;
        document.getElementById('dpd_id').value = user.dpd_id || "";
        document.getElementById('dpc_id').value = user.dpc_id || "";
        initializeModal();
        userModal.style.display = 'flex';
    };

    window.openDeleteModal = function (actionUrl) {
        console.log("Opening delete modal for:", actionUrl); // Debugging log
        deleteForm.setAttribute('action', actionUrl);
        deleteModal.style.display = 'flex';
    };

    window.closeModal = function () {
        console.log("Closing modal..."); // Debugging log
        userModal.style.display = 'none';
        deleteModal.style.display = 'none';
    };

    document.getElementById('cancelDelete').addEventListener('click', closeModal);
});


</script>

@endsection
