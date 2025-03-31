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

    <!-- Alpine.js for sidebar toggle -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Sidebar transition styles */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            .sidebar-closed {
                transform: translateX(-100%);
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"></div>

        <!-- Sidebar -->
        <div :class="{ 'sidebar-closed': !sidebarOpen }"
            class="sidebar-transition fixed md:static z-30 h-screen w-64 bg-white shadow-md md:translate-x-0">
            <x-admin-sidebar />
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header with Toggle Button -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <!-- Mobile sidebar toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-bars w-6 h-6"></i>
                    </button>
                    <div class="text-lg font-semibold text-gray-800">Admin Dashboard</div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Custom SweetAlert2 Toast Notifications -->
    <script src="{{ asset('js/sweetalert.js') }}"></script>

    <!-- Flash Messages for SweetAlert2 -->
    @if (session('success'))
        <script>
            var successMessage = "{{ session('success') }}";
        </script>
    @endif

    @if (session('error'))
        <script>
            var errorMessage = "{{ session('error') }}";
        </script>
    @endif

    @if (session('warning'))
        <script>
            var warningMessage = "{{ session('warning') }}";
        </script>
    @endif

    @if (session('info'))
        <script>
            var infoMessage = "{{ session('info') }}";
        </script>
    @endif

    @stack('scripts')
</body>

</html>
