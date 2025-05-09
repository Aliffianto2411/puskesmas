<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'User Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Main content area to avoid being overlapped by fixed sidebar */
    .main-content {
      margin-left: 250px; /* Sama dengan lebar sidebar */
      padding: 20px;
      background-color: #f8f9fa;
      min-height: 100vh;
    }
  </style>
</head>
<body>

  <!-- Sidebar Component -->
  <x-sidebar />

  <!-- Main Content -->
  <div class="main-content">
    @yield('content')
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
