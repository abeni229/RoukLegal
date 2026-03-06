<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RoukLegal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --secondary: #0f766e;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #f9fafb;
            --border: #e5e7eb;
            --text: #374151;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text);
            background: #f3f4f6;
        }

        /* dark mode overrides */
        body.dark-mode {
            background: var(--dark);
            color: var(--light);
        }
        body.dark-mode .sidebar {
            background: #374151;
        }
        body.dark-mode .sidebar .nav-link {
            color: var(--light);
        }
        body.dark-mode .sidebar .nav-link.active,
        body.dark-mode .sidebar .nav-link:hover {
            background: #4b5563;
            color: var(--light);
            border-left-color: var(--primary-light);
        }
        body.dark-mode .navbar {
            background: #111827;
        }
        body.dark-mode .card {
            background: #374151;
            border-color: #4b5563;
        }
        body.dark-mode .stat-card {
            color: var(--light);
        }
        body.dark-mode .content-wrapper {
            background: #1f2937;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            padding: 0.75rem 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 260px;
            height: calc(100vh - 56px);
            background: #ffffff;
            border-right: 1px solid var(--border);
            padding: 2rem 0;
            overflow-y: auto;
            z-index: 99;
        }

        .sidebar .nav-link {
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar .nav-link:hover {
            background: var(--light);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .sidebar .nav-link.active {
            background: var(--light);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .main-content {
            margin-left: 260px;
            padding-top: 56px;
            min-height: 100vh;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s;
            background: #ffffff;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .stat-card {
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid var(--border);
            text-align: center;
        }

        .stat-card.primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
        }

        .stat-card.success {
            background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
            color: white;
            border: none;
        }

        .stat-card.warning {
            background: linear-gradient(135deg, var(--warning) 0%, #fbbf24 100%);
            color: white;
            border: none;
        }

        .stat-card.secondary {
            background: linear-gradient(135deg, var(--secondary) 0%, #14b8a6 100%);
            color: white;
            border: none;
        }

        .stat-card.dark {
            background: linear-gradient(135deg, var(--dark) 0%, #4b5563 100%);
            color: white;
            border: none;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 1rem 0;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding: 1rem 0;
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 1rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="{{ auth()->check() ? auth()->user()->theme : 'light' }}-mode">
    @include('layouts.navbar')
    <div class="main-content">
        @isset($withSidebar)
            @include('layouts.sidebar')
        @endisset
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
