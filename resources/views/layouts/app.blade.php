<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Algoritma Sorting @yield('title')</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4a6fa5;
            --secondary: #166088;
            --accent: #4fc3f7;
            --light: #f5f5f5;
            --dark: #333;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light);
            color: var(--dark);
        }
        
        .navbar {
            background-color: var(--primary);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--secondary);
            color: white;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--dark);
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #2196f3;
            border-color: #2196f3;
        }
        
        .array-container {
            display: flex;
            justify-content: center;
            height: 300px;
            align-items: flex-end;
            margin-bottom: 20px;
        }
        
        .array-bar {
            width: 40px;
            margin: 0 2px;
            background-color: var(--primary);
            transition: height 0.3s, background-color 0.3s;
            position: relative;
        }
        
        .array-bar::after {
            content: attr(data-value);
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .array-bar.comparing {
            background-color: #ff9800;
        }
        
        .array-bar.sorted {
            background-color: #4caf50;
        }
        
        .array-display {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        
        .array-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            margin: 0 5px;
            background-color: var(--primary);
            color: white;
            border-radius: 5px;
        }
        
        .speed-control {
            display: flex;
            align-items: center;
            margin-top: 10px;
            gap: 10px;
        }
        
        .legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        
        .nav-tabs .nav-link {
            color: var(--dark);
        }
        
        .nav-tabs .nav-link.active {
            color: var(--secondary);
            font-weight: 600;
        }
        
        .code-block {
            background-color: #f5f5f5;
            border-radius: 4px;
            padding: 15px;
            font-family: monospace;
            overflow-x: auto;
            margin: 15px 0;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">Algoritma Sorting</a>
        </div>
    </nav>
    
    <div class="container">
        @yield('content')
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>