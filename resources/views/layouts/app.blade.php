<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Labkes System') - Laboratorium Kesehatan</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            color: #1a1a1a;
        }

        .main-content {
            margin-left: 280px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        /* Responsive main content */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 260px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Card styles */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Table styles */
        .data-table {
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
        }

        .data-table th {
            background: #f9fafb;
            padding: 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table td {
            padding: 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #f3f4f6;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #004b23;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #003518;
        }
    </style>

    @stack('styles')
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content">
        @include('layouts.navbar')

        <main style="padding: 2rem;">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>
