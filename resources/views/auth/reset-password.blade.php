<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Puspita Indah Konveksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg { background: linear-gradient(135deg, #0F2854 0%, #4988C4 100%); }
        .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-block bg-white rounded-full p-6 shadow-2xl mb-4">
                <i class="fas fa-lock text-5xl text-blue-600"></i>
            </div>
            <h1 class="text-xl font-bold text-white mb-2">Reset Password</h1>
            <p class="text-sm text-blue-100">Masukkan password baru Anda</p>
        </div>

        <div class="glass-effect rounded-2xl shadow-2xl p-8">
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Password Baru</label>
                    <input 
                        type="password" 
                        name="password"
                        class="w-full text-xs px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        class="w-full text-xs px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>

                <button 
                    type="submit"
                    class="w-full text-xs bg-gradient-to-r from-blue-800 to-blue-400 hover:from-blue-700 hover:to-blue-300 text-white font-semibold py-3 px-1 rounded-lg"
                >
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>