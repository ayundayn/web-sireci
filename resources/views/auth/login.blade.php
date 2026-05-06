<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen w-screen bg-teal-600 flex items-center justify-center">

    <div class="bg-white w-[450px] p-10 rounded-[40px] shadow-xl">

        <div class="text-center mb-6">

            <div class="flex justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-teal-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243A8 8 0 1117.657 16.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold">Login</h1>
            <p class="text-gray-500 text-sm">Selamat Datang Admin BanyuGuide</p>

        </div>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="Masukkan email anda">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500"
                    placeholder="Masukkan password anda">
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-sm">Ingatkan saya</span>
            </div>

            <button class="w-full bg-teal-600 text-white py-3 rounded-xl hover:bg-teal-700 transition">
                Login
            </button>

        </form>

    </div>

</body>

</html>
