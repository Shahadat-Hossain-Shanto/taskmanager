<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Tasks</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-item {
            background: #fff;
            border-left: 5px solid #0d6efd;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        /* .task-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.12);
        } */
        .btn-add-task {
            background-color: #fff;
            border: 2px dashed #0d6efd;
            color: #0d6efd;
            font-weight: bold;
        }
        .btn-add-task:hover {
            background-color: #0d6efd;
            color: #fff;
        }
        .remove-task {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4 text-primary">Create Tasks</h2>

    {{-- Show Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div id="tasks-wrapper">
            <div class="task-item">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Task <span class="task-number">1</span></h5>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-task">
                        <i class="bi bi-trash"></i> Remove
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="tasks[0][title]" class="form-control form-control-lg" placeholder="Enter task title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="tasks[0][description]" class="form-control" rows="2" placeholder="Enter task description"></textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Due Date</label>
                        <input type="date" name="tasks[0][due_date]" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="tasks[0][status]" class="form-select form-select-lg" required>
                            <option value="0">Pending</option>
                            <option value="1">In Progress</option>
                            <option value="2">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons Row -->
        <div class="d-flex justify-content-between mt-4">
            <button type="button" id="add-task" class="btn btn-add-task btn-lg">
                <i class="bi bi-plus-circle me-2"></i> Add Another Task
            </button>
            <button type="submit" class="btn btn-success btn-lg fw-bold">
                <i class="bi bi-check-circle me-2"></i> Submit
            </button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let taskIndex = 1;

    function updateTaskIndices() {
        $('#tasks-wrapper .task-item').each(function(index) {
            $(this).find('.task-number').text(index + 1);
            $(this).find('input, textarea, select').each(function() {
                let name = $(this).attr('name');
                $(this).attr('name', name.replace(/\d+/, index));
            });
        });
    }

    $('#add-task').click(function () {
        let newTask = $('.task-item:first').clone();
        newTask.find('input, textarea, select').each(function() {
            $(this).val('');
        });
        $('#tasks-wrapper').append(newTask);
        taskIndex++;
        updateTaskIndices();
    });

    $('#tasks-wrapper').on('click', '.remove-task', function () {
        if ($('#tasks-wrapper .task-item').length > 1) {
            $(this).closest('.task-item').remove();
            updateTaskIndices();
        } else {
            alert('At least one task is required.');
        }
    });
</script>
</body>
</html>
