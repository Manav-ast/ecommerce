<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- jQuery & jQuery Validation Plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <!-- SweetAlert2 Notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Toastr Notification -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="flex bg-gray-100">

    <!-- Sidebar -->
    <x-admin-sidebar />

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

    <!-- Custom SweetAlert2 Toast Notifications -->
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    
    <!-- Flash Messages for SweetAlert2 -->
    @if(session('success'))
        <script>
            var successMessage = "{{ session('success') }}";
        </script>
    @endif
    
    @if(session('error'))
        <script>
            var errorMessage = "{{ session('error') }}";
        </script>
    @endif
    
    @if(session('warning'))
        <script>
            var warningMessage = "{{ session('warning') }}";
        </script>
    @endif
    
    @if(session('info'))
        <script>
            var infoMessage = "{{ session('info') }}";
        </script>
    @endif
    
    @stack('scripts')
</body>

</html>
