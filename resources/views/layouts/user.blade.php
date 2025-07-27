<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'User Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- jQuery (jika kamu memang butuh, misalnya untuk AJAX) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    /* Main content area to avoid being overlapped by fixed sidebar */
    .main-content {
      margin-left: 250px; /* Sesuaikan dengan lebar sidebar kamu */
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

  <!-- Bootstrap JS (bundle wajib untuk dropdown, modal, dll) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
