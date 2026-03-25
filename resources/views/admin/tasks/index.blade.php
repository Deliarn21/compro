<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Master Tasks - Admin</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-300">← Admin</a>
                    <h1 class="text-2xl font-bold text-white">🔧 Kelola Master Tasks Digitalisasi</h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Success Message -->
        @if($message = session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ $message }}
            </div>
        @endif

        <!-- Create Button -->
        <div class="mb-8">
            <a href="{{ route('admin.tasks.create') }}" class="inline-block text-white font-semibold py-2 px-6 rounded-lg transition" style="background-color: #0e1c40;">
                ➕ Tambah Task Baru
            </a>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                <h3 class="text-lg font-bold text-white">🔍 Filter</h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('admin.tasks.index') }}" class="flex gap-4">
                    <div class="flex-1">
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @if($selectedCategory === $category) selected @endif>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 text-white rounded-lg font-semibold" style="background-color: #0e1c40;">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                <h2 class="text-xl font-bold text-white">📋 Master Tasks (Total: {{ $tasks->total() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama Task</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kesulitan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Durasi Estimasi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $task->task_name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($task->description, 60) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        {{ $task->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($task->difficulty_level === 'easy') bg-green-100 text-green-800
                                        @elseif($task->difficulty_level === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($task->difficulty_level) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $task->estimated_duration ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</a>
                                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600" onclick="return confirm('Hapus task ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600">Tidak ada tasks</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tasks->total() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ count($tasks) }} dari {{ $tasks->total() }} tasks
                    </div>
                    <div class="flex gap-2">
                        @if($tasks->currentPage() == 1)
                            <button class="px-3 py-1 bg-gray-200 text-gray-400 rounded cursor-not-allowed" disabled>← Sebelumnya</button>
                        @else
                            <a href="{{ $tasks->appends(request()->query())->previousPageUrl() }}" class="px-3 py-1 text-white rounded" style="background-color: #0e1c40;">← Sebelumnya</a>
                        @endif

                        @for($page = 1; $page <= $tasks->lastPage(); $page++)
                            @if($page == $tasks->currentPage())
                                <button class="px-3 py-1 text-white rounded font-semibold" style="background-color: #0e1c40;">{{ $page }}</button>
                            @else
                                <a href="{{ $tasks->appends(request()->query())->url($page) }}" class="px-3 py-1 bg-gray-200 text-gray-900 rounded hover:bg-gray-300">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($tasks->currentPage() < $tasks->lastPage())
                            <a href="{{ $tasks->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1 text-white rounded" style="background-color: #0e1c40;">Berikutnya →</a>
                        @else
                            <button class="px-3 py-1 bg-gray-200 text-gray-400 rounded cursor-not-allowed" disabled>Berikutnya →</button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-300 text-sm">
            <p>© 2026 Management Information System & Technology | Hasnur Group</p>
        </div>
    </main>
</body>
</html>
