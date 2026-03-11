<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="text-2xl font-black text-indigo-600 tracking-tighter">FINTRACK.</div>
        <div class="space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-bold text-gray-600 hover:text-indigo-600">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-indigo-600">Login</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-indigo-700 transition">Daftar</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-7xl mx-auto mt-20 px-6 text-center">
        <h1 class="text-6xl md:text-8xl font-black mb-8 leading-tight">
            Urus Duit <br> <span class="text-indigo-600">Jadi Lebih Bijak.</span>
        </h1>
        <p class="text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
            Jejak perbelanjaan, pantau aliran tunai, dan capai matlamat kewangan anda dengan sistem yang mudah dan moden.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-gray-900 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-black transition">Mula Sekarang</a>
        </div>
    </main>

    <footer class="mt-20 py-10 text-center text-gray-400 text-sm">
        &copy; 2026 FINTRACK. by irfan
    </footer>

</body>
</html>