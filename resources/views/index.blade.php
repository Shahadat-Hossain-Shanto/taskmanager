<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-primary {
            border-top: 4px solid #0d6efd;
        }
        .btn-sm {
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="card card-primary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><strong><i class="fas fa-tasks"></i> Task List</strong></h5>
            <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Go Back
            </a>
        </div>

        <div class="card-body">
            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Task Table --}}
            <div class="table-responsive">
                <table id="taskTable" class="table table-bordered table-striped table-hover dt-responsive nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editStatusForm">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusLabel">Update Task Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="task_id" name="task_id">
                    <div class="mb-3">
                        <label for="task_status" class="form-label">Status</label>
                        <select id="task_status" name="status" class="form-select" required>
                            <option value="0">Pending</option>
                            <option value="1">In Progress</option>
                            <option value="2">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<script>
    $(document).ready(function() {
        const table = new DataTable('#taskTable', {
            ajax: '{{ route("tasks.data") }}',
            responsive: true,
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 },
                { data: 'title' },
                { data: 'description' },
                { data: 'due_date' },
                {
                    data: 'status',
                    render: status => {
                        switch(status){
                            case 0: return '<span class="badge bg-danger">Pending</span>';
                            case 1: return '<span class="badge bg-primary">In Progress</span>';
                            case 2: return '<span class="badge bg-success">Completed</span>';
                            default: return '<span class="badge bg-dark">Unknown</span>';
                        }
                    }
                },
                { data: 'created_at', render: d => new Date(d).toLocaleString() },
                {
                    data: null,
                    render: row => `
                        <button class="btn btn-warning btn-sm edit-status-btn me-1" data-id="${row.id}" data-status="${row.status}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/tasks/${row.id}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>`,
                    orderable: false,
                    searchable: false
                }
            ],
            searching: true,
            ordering: true,
            paging: true
        });

        // Open modal to edit status
        $('#taskTable').on('click', '.edit-status-btn', function() {
            const taskId = $(this).data('id');
            const status = $(this).data('status');

            $('#task_id').val(taskId);
            $('#task_status').val(status);
            new bootstrap.Modal(document.getElementById('editStatusModal')).show();
        });

        // Submit status update via AJAX
        $('#editStatusForm').submit(function(e) {
            e.preventDefault();
            const taskId = $('#task_id').val();
            const status = $('#task_status').val();

            $.ajax({
                url: `/tasks/${taskId}/status`,
                method: 'PATCH',
                data: { _token: '{{ csrf_token() }}', status },
                success: function() {
                    const modalEl = document.getElementById('editStatusModal');
                    bootstrap.Modal.getInstance(modalEl).hide();
                    table.ajax.reload(null, false); // reload data without resetting pagination
                    $('<div class="alert alert-success alert-dismissible fade show mt-2">Task status updated successfully!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>').prependTo('.card-body').delay(3000).fadeOut(500, function(){ $(this).remove(); });
                },
                error: function() {
                    $('<div class="alert alert-danger alert-dismissible fade show mt-2">Failed to update status.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>').prependTo('.card-body').delay(3000).fadeOut(500, function(){ $(this).remove(); });
                }
            });
        });
    });
</script>

</body>
</html>
