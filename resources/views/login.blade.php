@extends('header')

@section('title','Login')

@section('page')
<body class="min-h-screen w-full flex items-center justify-center" style="background-image: url('back.jpg'); background-size: cover; background-position: center;">
    <!-- Container untuk form login -->
    <div class="bg-white shadow-lg rounded-2xl p-10 w-1/3">
        <div class="flex flex-col items-center">
            <!-- Logo -->
            <img src="Logo.jpg" alt="SMRS Logo" class="w-70 mb-4">
            <h2 class="text-2xl font-semibold text-gray-700">────── LOGIN ──────</h2>
        </div>
        
        <form action="{{ route('login') }}" method="POST" class="mt-8">
            @csrf
            <!-- Email field -->
            <div class="flex items-center border rounded-lg mb-4 bg-gray-100">
                <span class="px-3 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0 014-4zm0 10a5 5 0 00-5 5v1a1 1 0 001 1h8a1 1 0 001-1v-1a5 5 0 00-5-5z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <input type="text" name="email" placeholder="E-mail/Username" class="w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-400 rounded-r-lg" required>
            </div>

            <!-- Password field -->
            <div class="flex items-center border rounded-lg mb-4 bg-gray-100">
                <span class="px-3 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 4a4 4 0 00-4 4v1H5a3 3 0 00-3 3v3a3 3 0 003 3h10a3 3 0 003-3v-3a3 3 0 00-3-3h-1V8a4 4 0 00-4-4zM8 8a2 2 0 114 0v1H8V8zm5 3H7v4h6v-4z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <input type="password" name="password" placeholder="Password" class="w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-400 rounded-r-lg" required>
            </div>

            <!-- Login button -->
            <button type="submit" class="w-full py-2 bg-red-300 font-semibold text-black rounded-lg hover:bg-red-400 focus:outline-none focus:ring-4 focus:ring-red-300">Login</button>
        </form>
    </div>
</body>
</html>
