<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SIRECI</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 overflow-x-hidden">

    <!-- MOBILE OVERLAY -->
    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden">
    </div>

    <!-- NAVBAR -->
    <header
        class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 z-50">

        <div class="h-full px-4 lg:px-8 flex items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center gap-3">

                <!-- HAMBURGER -->
                <button id="menuButton"
                    class="lg:hidden w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-gray-700"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                    </svg>

                </button>

                <!-- LOGO -->
                <div class="flex items-center gap-2">

                    <div
                        class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-teal-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243A8 8 0 1117.657 16.657z" />

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                        </svg>

                    </div>

                    <div>

                        <h1 class="text-lg font-bold text-gray-800 leading-tight">
                            SI<span class="text-teal-600">RECI</span>
                        </h1>

                        <p class="text-xs text-gray-500">
                            Admin Panel
                        </p>

                    </div>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="relative">

                <button onclick="toggleDropdown()"
                    class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-semibold shadow-sm hover:scale-105 transition">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </button>

                <!-- DROPDOWN -->
                <div id="dropdownMenu"
                    class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">

                    <div class="px-5 py-4 border-b border-gray-100">

                        <p class="font-semibold text-gray-800">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Admin
                        </p>

                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="w-full text-left px-5 py-3 text-red-500 hover:bg-red-50 transition">

                            Logout

                        </button>
                    </form>

                </div>

            </div>

        </div>

    </header>


    <div class="flex pt-16">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="fixed lg:sticky top-16 left-0 z-50 lg:z-30
            w-72 lg:w-64 h-[calc(100vh-64px)]
            bg-white border-r border-gray-100
            transform -translate-x-full lg:translate-x-0
            transition-transform duration-300 ease-in-out
            overflow-y-auto">

            <div class="p-5 space-y-2">

                <!-- DASHBOARD -->
                <a href="/admin/dashboard"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition
                    {{ request()->is('admin/dashboard')
                        ? 'bg-teal-600 text-white shadow-md'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5
                        {{ request()->is('admin/dashboard')
                            ? 'text-white'
                            : 'text-teal-600'
                        }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 13h8V3H3v10zm10 8h8V3h-8v18z" />

                    </svg>

                    Dashboard

                </a>


                <!-- KATEGORI -->
                <a href="/admin/kategori"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition
                    {{ request()->is('admin/kategori*')
                        ? 'bg-teal-600 text-white shadow-md'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5
                        {{ request()->is('admin/kategori*')
                            ? 'text-white'
                            : 'text-teal-600'
                        }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />

                    </svg>

                    Kategori

                </a>


                <!-- WISATA -->
                <a href="/admin/wisata"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition
                    {{ request()->is('admin/wisata*')
                        ? 'bg-teal-600 text-white shadow-md'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5
                        {{ request()->is('admin/wisata*')
                            ? 'text-white'
                            : 'text-teal-600'
                        }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-1.553 1.894L15 20m-6 0v-6m6 6v-6" />

                    </svg>

                    Wisata

                </a>


                <!-- KULINER -->
                <a href="/admin/kuliner"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition
                    {{ request()->is('admin/kuliner*')
                        ? 'bg-teal-600 text-white shadow-md'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5
                        {{ request()->is('admin/kuliner*')
                            ? 'text-white'
                            : 'text-teal-600'
                        }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h18M4 7h16M6 11h12M8 15h8M10 19h4" />

                    </svg>

                    Kuliner

                </a>


                <!-- PENILAIAN -->
                <a href="{{ route('admin.uat.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition
                    {{ request()->is('admin/uat*')
                        ? 'bg-teal-600 text-white shadow-md'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5
                        {{ request()->is('admin/uat*')
                            ? 'text-white'
                            : 'text-teal-600'
                        }}"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 17v-6h13v6M9 5v6h13V5M3 5h.01M3 12h.01M3 19h.01" />

                    </svg>

                    Penilaian

                </a>

            </div>

        </aside>


        <!-- CONTENT -->
        <main class="flex-1 min-w-0 p-4 md:p-6 lg:p-8">

            @yield('content')

        </main>

    </div>


    <script>

        // DROPDOWN
        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        }

        // SIDEBAR
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuButton = document.getElementById('menuButton');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // CLOSE DROPDOWN
        window.addEventListener('click', function (e) {

            const dropdown = document.getElementById('dropdownMenu');

            if (!e.target.closest('.relative')) {
                dropdown.classList.add('hidden');
            }

        });

    </script>

</body>

</html>
