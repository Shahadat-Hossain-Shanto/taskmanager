<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - README</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 18px;
            border: none;
        }
        h1, h2, h3, h4 {
            font-weight: 600;
        }
        h1 {
            color: #0d6efd;
        }
        h2 {
            color: #495057;
            border-left: 5px solid #0d6efd;
            padding-left: 10px;
            margin-top: 30px;
        }
        ul li {
            margin-bottom: 8px;
        }
        pre {
            background: #1e293b;
            color: #f8f9fa;
            padding: 14px;
            border-radius: 10px;
            font-size: 0.95rem;
            overflow-x: auto;
        }
        code {
            color: #3d00d7;
        }
        .section-divider {
            border-top: 2px dashed #dee2e6;
            margin: 30px 0;
        }
        .btn-outline-primary {
            border-radius: 30px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-body p-5">
            <h1 class="mb-4 text-center"><i class="bi bi-journal-code"></i> Task Management - README</h1>

            {{-- Setup Section --}}
            <h2>⚙️ Setup</h2>
            <ul>
                <li>Clone the repository: <code>git clone https://github.com/Shahadat-Hossain-Shanto/taskmanager.git</code></li>
                <li>Install dependencies: <code>composer install</code></li>
                <li>Copy environment file: <code>cp .env.example .env</code></li>
                <li>Generate app key: <code>php artisan key:generate</code></li>
                <li>Configure DB in <code>.env</code></li>
                <li>Run migrations: <code>php artisan migrate</code></li>
                <li>Serve the app: <code>php artisan serve</code></li>
            </ul>

            <div class="section-divider"></div>

            {{-- Architecture Section --}}
            <h2>🏗️ Architecture</h2>
            <p>This is a Laravel 12 project following MVC architecture:</p>
            <ul>
                <li><strong>Models</strong>: <code>App\Models\Task</code> for database interaction</li>
                <li><strong>Controllers</strong>: <code>App\Http\Controllers\TaskController</code> handles task logic</li>
                <li><strong>Routes</strong>: Defined in <code>routes/api.php</code> and <code>routes/web.php</code></li>
                <li><strong>Views</strong>: Blade templates for frontend (Bootstrap 5)</li>
                <li><strong>Database</strong>: MySQL with tasks table</li>
            </ul>

            <div class="section-divider"></div>

            {{-- Scalability Section --}}
            <h2>🚀 Scalability</h2>
            <ul>
                <li>API supports bulk task insertion</li>
                <li>Validation layer ensures data consistency</li>
                <li>Rate limiting applied with <code>throttle</code> middleware</li>
                <li>Stateless API with token-based Authorization</li>
                <li>Future-ready for horizontal scaling with Redis queues + load balancers</li>
            </ul>

            <div class="section-divider"></div>

            {{-- API Documentation --}}
            <h2>📡 API Documentation</h2>

            <h3>🔹 Create Tasks API</h3>
            <p><strong>Endpoint:</strong> <code>POST /api/task-store</code></p>

            <h4>Headers:</h4>
            <pre><code>Authorization: hT9vXb2qLr8YnZp5S1QwKg==
Content-Type: application/json
Accept: application/json</code></pre>

            <h4>Request Body:</h4>
            <pre><code>{
    "tasks": [
        {
            "title": "Finish API documentation",
            "description": "Complete the API documentation for Task management",
            "due_date": "2025-10-01",
            "status": 1
        },
        {
            "title": "Setup frontend integration",
            "due_date": "2025-10-05",
            "status": 0
        }
    ]
}</code></pre>

            <h4>✅ Success Response:</h4>
            <pre><code>{
    "status": 200,
    "message": "Tasks created successfully.",
    "data": [
        {
            "title": "Finish API documentation",
            "due_date": "2025-10-01",
            "status": 1
        },
        {
            "title": "Setup frontend integration",
            "due_date": "2025-10-05",
            "status": 0
        }
    ]
}</code></pre>

            <h4>❌ Validation Error Response:</h4>
            <pre><code>{
    "status": 422,
    "message": "Validation Error",
    "errors": {
        "tasks.0.title": ["The title field is required."],
        "tasks.1.due_date": ["The due date field is required."]
    }
}</code></pre>

            <h4>🔒 Unauthorized Response:</h4>
            <pre><code>{
    "status": 400,
    "message": "Unauthorized Access"
}</code></pre>

            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="btn btn-outline-primary px-4 py-2">
                    <i class="bi bi-arrow-left-circle me-1"></i> Go Back
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
