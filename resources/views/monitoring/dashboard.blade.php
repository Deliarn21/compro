<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digitalisasi Monitoring - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .status-badge {
            @apply px-3 py-1 rounded-full text-sm font-semibold;
        }
        .status-completed {
            @apply bg-green-100 text-green-800;
        }
        .status-in_progress {
            @apply bg-blue-100 text-blue-800;
        }
        .status-pending {
            @apply bg-yellow-100 text-yellow-800;
        }
        .status-delayed {
            @apply bg-red-100 text-red-800;
        }
        body {
            background: linear-gradient(135deg, #0e1c40 0%, #1a2e5f 50%, #0f2447 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <nav class="bg-white border-b-4 border-gray-200" style="background-color: #0e1c40;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">📊 Digitalisasi Monitoring</h1>
                </div>
                <div class="text-sm text-gray-300">
                    Dashboard Pemantauan Digitalisasi Perusahaan
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <!-- Total Progress -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Progress</p>
                        <p class="text-3xl font-bold text-blue-600">{{ round($statistics['total_progress']) }}%</p>
                    </div>
                    <div class="text-4xl">📈</div>
                </div>
            </div>

            <!-- Total Items -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Items</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ $statistics['total_items'] }}</p>
                    </div>
                    <div class="text-4xl">📋</div>
                </div>
            </div>

            <!-- Completed Items -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Selesai</p>
                        <p class="text-3xl font-bold text-green-600">{{ $statistics['completed_items'] }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>

            <!-- In Progress Items -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Sedang Berjalan</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $statistics['in_progress_items'] }}</p>
                    </div>
                    <div class="text-4xl">⏳</div>
                </div>
            </div>

            <!-- Delayed Items -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Tertunda</p>
                        <p class="text-3xl font-bold text-red-600">{{ $statistics['delayed_items'] }}</p>
                    </div>
                    <div class="text-4xl">⚠️</div>
                </div>
            </div>
        </div>

        <!-- Entities Overview -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                <h2 class="text-xl font-bold text-white">📍 Ringkasan Per Entitas (Klik untuk Detail)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama Entitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Total Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($entities as $entity)
                            <tr class="hover:bg-blue-50 transition cursor-pointer" onclick="window.location.href='{{ route('monitoring.entities.detail', $entity['id']) }}'">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    <span class="text-blue-600 hover:text-blue-900">{{ $entity['name'] }} →</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $entity['code'] }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold @if($entity['type'] === 'pt') bg-purple-100 text-purple-800 @else bg-cyan-100 text-cyan-800 @endif">
                                        @if($entity['type'] === 'pt') PT/Entitas @else Departemen @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-32">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-semibold text-gray-900">{{ $entity['average_progress'] }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: {{ $entity['average_progress'] }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $entity['total_items'] }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="text-green-600 font-semibold">{{ $entity['completed_items'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-600">Tidak ada entitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                <h3 class="text-lg font-bold text-white mb-4">🔍 Filter Data</h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('monitoring.dashboard') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Entity Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entitas</label>
                        <select name="entity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Entitas</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity['id'] }}" @if($filters['entity'] == $entity['id']) selected @endif>
                                    {{ $entity['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="completed" @if($filters['status'] === 'completed') selected @endif>Selesai</option>
                            <option value="in_progress" @if($filters['status'] === 'in_progress') selected @endif>Sedang Berjalan</option>
                            <option value="pending" @if($filters['status'] === 'pending') selected @endif>Menunggu</option>
                            <option value="delayed" @if($filters['status'] === 'delayed') selected @endif>Tertunda</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @if($filters['category'] === $category) selected @endif>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200" style="background-color: #0e1c40;">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                <h2 class="text-xl font-bold text-white">📝 Item Digitalisasi</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Entitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal Target</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">PIC</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->item_name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($item->description, 50) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->entity->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        {{ $item->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-24">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-semibold text-gray-900">{{ $item->progress_actual }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $item->progress_actual }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="status-badge status-{{ $item->status }}">
                                        @if($item->status === 'completed')
                                            ✅ Selesai
                                        @elseif($item->status === 'in_progress')
                                            ⏳ Sedang Berjalan
                                        @elseif($item->status === 'pending')
                                            📌 Menunggu
                                        @elseif($item->status === 'delayed')
                                            ⚠️ Tertunda
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $item->target_date ? $item->target_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->assigned_to ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-600">Tidak ada item yang sesuai dengan filter</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($items->count() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ count($items) }} dari {{ $items->total() }} item (Halaman {{ $items->currentPage() }})
                    </div>
                    <div class="flex gap-2">
                        @if($items->currentPage() == 1)
                            <button class="px-3 py-1 bg-gray-200 text-gray-400 rounded cursor-not-allowed" disabled>← Sebelumnya</button>
                        @else
                            <a href="{{ $items->appends(request()->query())->previousPageUrl() }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700" style="background-color: #0e1c40;">← Sebelumnya</a>
                        @endif

                        @for($page = 1; $page <= $items->lastPage(); $page++)
                            @if($page == $items->currentPage())
                                <button class="px-3 py-1 text-white rounded font-semibold" style="background-color: #0e1c40;">{{ $page }}</button>
                            @else
                                <a href="{{ $items->appends(request()->query())->url($page) }}" class="px-3 py-1 bg-gray-200 text-gray-900 rounded hover:bg-gray-300">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($items->currentPage() < $items->lastPage())
                            <a href="{{ $items->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700" style="background-color: #0e1c40;">Berikutnya →</a>
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
