<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Master Task - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0e1c40 0%, #1a2e5f 50%, #0f2447 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="bg-white border-b-4 border-gray-200" style="background-color: #0e1c40;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.tasks.index') }}" class="text-white hover:text-gray-300">← Kembali</a>
                    <h1 class="text-2xl font-bold text-white">✏️ Edit Master Task</h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <!-- Task Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Task *</label>
                    <input type="text" name="task_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('task_name') border-red-500 @enderror" value="{{ old('task_name', $task->task_name) }}" required>
                    @error('task_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <input type="text" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror" value="{{ old('category', $task->category) }}" required>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estimated Duration -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Estimasi</label>
                    <input type="text" name="estimated_duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('estimated_duration', $task->estimated_duration) }}">
                </div>

                <!-- Difficulty Level -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kesulitan *</label>
                    <select name="difficulty_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('difficulty_level') border-red-500 @enderror" required>
                        <option value="easy" @if(old('difficulty_level', $task->difficulty_level) === 'easy') selected @endif>Mudah (Easy)</option>
                        <option value="medium" @if(old('difficulty_level', $task->difficulty_level) === 'medium') selected @endif>Sedang (Medium)</option>
                        <option value="hard" @if(old('difficulty_level', $task->difficulty_level) === 'hard') selected @endif>Sulit (Hard)</option>
                    </select>
                    @error('difficulty_level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Info:</strong> Task ini dibuat pada {{ $task->created_at->format('d M Y H:i') }}
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 text-white font-semibold py-3 rounded-lg transition" style="background-color: #0e1c40;">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.tasks.index') }}" class="flex-1 bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg text-center hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-300 text-sm">
            <p>© 2026 Management Information System & Technology | Hasnur Group</p>
        </div>
    </main>
</body>
</html>
