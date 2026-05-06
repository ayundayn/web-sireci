<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin BanyuGuide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">

    <!-- NAVBAR -->
    <div class="w-full bg-white border-b px-12 py-3 flex items-center sticky top-0 z-50">

        <!-- LEFT : LOGO -->
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-teal-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243A8 8 0 1117.657 16.657z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <h1 class="text-xl font-bold">
                Banyu<span class="text-teal-600">Guide</span>
            </h1>

            <span class="text-gray-500 text-sm">Admin</span>
        </div>


        <!-- CENTER : SEARCH -->
        <div class="flex-1 flex justify-center">
            <input type="text" placeholder="Cari"
                class="w-80 bg-gray-100 border rounded-full px-4 py-2 focus:outline-none" />
        </div>


        <!-- RIGHT : PROFILE -->
        <div class="flex justify-end">
            <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 font-semibold">
                A
            </div>
        </div>

    </div>


    <div class="flex">

        <!-- SIDEBAR -->
        <div class="w-64 bg-white shadow-md min-h-screen p-6">

            <div class="space-y-4">

                <!-- DASHBOARD -->
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->is('admin/dashboard') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5
                        {{ request()->is('admin/dashboard') ? 'text-white' : 'text-teal-600' }}" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 13h8V3H3v10zm10 8h8V3h-8v18z" />

                    </svg>

                    Dashboard
                </a>

                <!-- KATEGORI -->
                <a href="/admin/kategori" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->is('admin/kategori*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5
                        {{ request()->is('admin/kategori*') ? 'text-white' : 'text-teal-600' }}" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />

                    </svg>

                    Kategori
                </a>

                <!-- WISATA -->
                <a href="/admin/wisata" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->is('admin/wisata*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5
                        {{ request()->is('admin/wisata*') ? 'text-white' : 'text-teal-600' }}" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-1.553 1.894L15 20m-6 0v-6m6 6v-6" />

                    </svg>

                    Wisata
                </a>


                <!-- KULINER -->
                <a href="/admin/kuliner" class="flex items-center gap-3 px-4 py-3 rounded-xl
                    {{ request()->is('admin/kuliner*') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5
                        {{ request()->is('admin/kuliner*') ? 'text-white' : 'text-teal-600' }}" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h18M4 7h16M6 11h12M8 15h8M10 19h4" />

                    </svg>

                    Kuliner
                </a>

            </div>

        </div>


        <!-- CONTENT -->
        <div class="flex-1 p-10">

            @yield('content')

        </div>

    </div>

</body>

</html>
