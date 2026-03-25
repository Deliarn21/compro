<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Entitas - {{ $entity->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0e1c40 0%, #1a2e5f 50%, #0f2447 100%);
            min-height: 100vh;
        }
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
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="bg-white border-b-4 border-gray-200" style="background-color: #0e1c40;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('monitoring.dashboard') }}" class="text-white hover:text-gray-300">← Dashboard</a>
                    <h1 class="text-2xl font-bold text-white">{{ $entity->name }}</h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Entity Info -->
        <div class="bg-white rounded-lg shadow mb-8 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 font-semibold">NAMA ENTITAS</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $entity->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">KODE</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $entity->code }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">TIPE</p>
                    <p class="text-lg font-semibold">
                        <span class="px-3 py-1 rounded-full text-sm @if($entity->type === 'pt') bg-purple-100 text-purple-800 @else bg-cyan-100 text-cyan-800 @endif">
                            @if($entity->type === 'pt') PT/Entitas @else Departemen @endif
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold">PROGRESS KESELURUHAN</p>
                    <p class="text-2xl font-bold text-blue-600">{{ round($entity->average_progress) }}%</p>
                    <div class="w-full bg-gray-200 rounded-full h-3 mt-2">
                        <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $entity->average_progress }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-gray-700"><strong>Deskripsi:</strong> {{ $entity->description ?? '-' }}</p>
                <p class="text-gray-700 mt-2"><strong>PIC:</strong> {{ $entity->contact_person ?? '-' }}</p>
                <p class="text-gray-700"><strong>Email:</strong> {{ $entity->contact_email ?? '-' }}</p>
                <p class="text-gray-700"><strong>Telepon:</strong> {{ $entity->contact_phone ?? '-' }}</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <p class="text-gray-600 text-sm font-medium">Total Tasks Dipilih</p>
                <p class="text-3xl font-bold text-blue-600">{{ $entity->total_items }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <p class="text-gray-600 text-sm font-medium">Tasks Selesai</p>
                <p class="text-3xl font-bold text-green-600">{{ $entity->completed_items }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <p class="text-gray-600 text-sm font-medium">Tasks Berlangsung</p>
                <p class="text-3xl font-bold text-yellow-600">
                    {{ $entity->digitalizationTasks()->where('entity_digitalization_tasks.status', 'in_progress')->count() }}
                </p>
            </div>
        </div>

        <!-- Add New Task -->
        @if($availableTasks->count() > 0)
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                    <h2 class="text-xl font-bold text-white">➕ Tambah Task Baru</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('monitoring.entities.attachTask', $entity->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Task Digitalisasi Dari Master</label>
                                <select name="digitalization_task_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">-- Pilih Task --</option>
                                    @foreach($availableTasks as $task)
                                        <option value="{{ $task->id }}">
                                            {{ $task->task_name }} ({{ $task->category }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-200" style="background-color: #0e1c40;">
                                    Tambah Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Selected Tasks -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200" style="background-color: #0e1c40;">
                <h2 class="text-xl font-bold text-white">📋 Tasks yang Dipilih ({{ $entity->digitalizationTasks()->count() }})</h2>
            </div>
            
            @forelse($selectedTasks as $task)
                <div class="p-6 border-b border-gray-200 hover:bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $task->task_name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                            <div class="mt-2 flex gap-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">{{ $task->category }}</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">Kesulitan: {{ ucfirst($task->difficulty_level) }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-gray-900">Progress</span>
                                    <span class="text-2xl font-bold text-blue-600">{{ $task->pivot->progress_actual }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $task->pivot->progress_actual }}%"></div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="status-badge status-{{ $task->pivot->status }}">
                                    @if($task->pivot->status === 'completed')
                                        ✅ Selesai
                                    @elseif($task->pivot->status === 'in_progress')
                                        ⏳ Sedang Berjalan
                                    @elseif($task->pivot->status === 'pending')
                                        📌 Menunggu
                                    @elseif($task->pivot->status === 'delayed')
                                        ⚠️ Tertunda
                                    @endif
                                </span>
                                <div class="flex gap-2">
                                    <button onclick="showEditModal({{ $entity->id }}, {{ $task->id }}, '{{ $task->pivot->progress_actual }}', '{{ $task->pivot->status }}', '{{ $task->pivot->assigned_to }}', `{{ $task->pivot->notes }}`)" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</button>
                                    <button onclick="showHistoryModal({{ $entity->id }}, {{ $task->id }})" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">📜 History</button>
                                    <form action="{{ route('monitoring.entities.detachTask', [$entity->id, $task->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600" onclick="return confirm('Hapus task ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-600">
                    Belum ada tasks yang dipilih. 
                    @if($availableTasks->count() > 0)
                        <a href="#" class="text-blue-600 hover:text-blue-900">Tambahkan sekarang</a>
                    @endif
                </div>
            @endforelse

            <!-- Pagination -->
            @if($selectedTasks->total() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ count($selectedTasks) }} dari {{ $selectedTasks->total() }} tasks
                    </div>
                    <div class="flex gap-2">
                        @if($selectedTasks->currentPage() == 1)
                            <button class="px-3 py-1 bg-gray-200 text-gray-400 rounded cursor-not-allowed" disabled>← Sebelumnya</button>
                        @else
                            <a href="{{ $selectedTasks->previousPageUrl() }}" class="px-3 py-1 text-white rounded" style="background-color: #0e1c40;">← Sebelumnya</a>
                        @endif

                        @for($page = 1; $page <= $selectedTasks->lastPage(); $page++)
                            @if($page == $selectedTasks->currentPage())
                                <button class="px-3 py-1 text-white rounded font-semibold" style="background-color: #0e1c40;">{{ $page }}</button>
                            @else
                                <a href="{{ $selectedTasks->url($page) }}" class="px-3 py-1 bg-gray-200 text-gray-900 rounded hover:bg-gray-300">{{ $page }}</a>
                            @endif
                        @endfor

                        @if($selectedTasks->currentPage() < $selectedTasks->lastPage())
                            <a href="{{ $selectedTasks->nextPageUrl() }}" class="px-3 py-1 text-white rounded" style="background-color: #0e1c40;">Berikutnya →</a>
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

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full max-h-96 overflow-y-auto">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Progress Task</h3>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progress (%)</label>
                    <input type="number" id="progressInput" name="progress_actual" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="statusInput" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        <option value="pending">Menunggu</option>
                        <option value="in_progress">Sedang Berjalan</option>
                        <option value="completed">Selesai</option>
                        <option value="delayed">Tertunda</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">PIC / Assignee</label>
                    <input type="text" id="assignedInput" name="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <textarea id="notesInput" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📎 Upload Bukti/Proof (PDF, JPG, PNG, DOC - Max 5MB)</label>
                    <input type="file" id="proofFileInput" name="proof_file" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    <p class="text-xs text-gray-500 mt-1">* Upload adalah optional - bisa diisi untuk menyimpan bukti progress</p>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 text-white font-semibold py-2 rounded-lg transition" style="background-color: #0e1c40;">Simpan</button>
                    <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-300 text-gray-900 font-semibold py-2 rounded-lg hover:bg-gray-400">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl w-full max-h-96 overflow-y-auto">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📜 History Activity Task</h3>
            <div id="historyContent" class="space-y-4">
                <p class="text-gray-600">Loading...</p>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeHistoryModal()" class="bg-gray-300 text-gray-900 font-semibold py-2 px-6 rounded-lg hover:bg-gray-400">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showEditModal(entityId, taskId, progress, status, assigned, notes) {
            document.getElementById('progressInput').value = progress;
            document.getElementById('statusInput').value = status;
            document.getElementById('assignedInput').value = assigned || '';
            document.getElementById('notesInput').value = notes || '';
            document.getElementById('editForm').action = `/monitoring/entities/${entityId}/tasks/${taskId}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function showHistoryModal(entityId, taskId) {
            document.getElementById('historyModal').classList.remove('hidden');
            loadHistory(entityId, taskId);
        }

        function closeHistoryModal() {
            document.getElementById('historyModal').classList.add('hidden');
        }

        function loadHistory(entityId, taskId) {
            fetch(`/monitoring/entities/${entityId}/tasks/${taskId}/history`)
                .then(response => response.json())
                .then(data => {
                    const historyContent = document.getElementById('historyContent');
                    if (data.length === 0) {
                        historyContent.innerHTML = '<p class="text-gray-600">Belum ada history activity</p>';
                        return;
                    }

                    historyContent.innerHTML = data.map(log => {
                        const date = new Date(log.created_at).toLocaleString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        let activityType = log.activity_type;
                        let badge = 'bg-gray-100 text-gray-800';
                        
                        if (log.activity_type === 'progress_update') {
                            badge = 'bg-blue-100 text-blue-800';
                            activityType = '📈 Update Progress';
                        } else if (log.activity_type === 'status_change') {
                            badge = 'bg-yellow-100 text-yellow-800';
                            activityType = '🔄 Perubahan Status';
                        } else if (log.activity_type === 'task_added') {
                            badge = 'bg-green-100 text-green-800';
                            activityType = '➕ Task Ditambah';
                        } else if (log.activity_type === 'task_removed') {
                            badge = 'bg-red-100 text-red-800';
                            activityType = '❌ Task Dihapus';
                        } else if (log.activity_type === 'proof_upload') {
                            badge = 'bg-purple-100 text-purple-800';
                            activityType = '📎 Upload Bukti';
                        }

                        return `
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <span class="px-2 py-1 rounded text-xs font-semibold ${badge}">
                                        ${activityType}
                                    </span>
                                    <span class="text-xs text-gray-500">${date}</span>
                                </div>
                                
                                <div class="text-sm">
                                    <p class="text-gray-700 font-medium">by <strong>${log.user_name}</strong></p>
                                    
                                    ${log.progress_before !== null && log.progress_after !== null ? `
                                        <p class="text-gray-600 mt-1">
                                            Progress: <strong>${log.progress_before}%</strong> → <strong>${log.progress_after}%</strong>
                                        </p>
                                    ` : ''}
                                    
                                    ${log.status_before && log.status_after ? `
                                        <p class="text-gray-600 mt-1">
                                            Status: <strong>${log.status_before}</strong> → <strong>${log.status_after}</strong>
                                        </p>
                                    ` : ''}
                                    
                                    ${log.notes ? `
                                        <p class="text-gray-600 mt-1">
                                            <strong>Catatan:</strong> ${log.notes}
                                        </p>
                                    ` : ''}
                                    
                                    ${log.proof_file_original ? `
                                        <p class="text-gray-600 mt-1">
                                            <strong>📎 Bukti:</strong> <a href="/storage/${log.proof_file}" target="_blank" class="text-blue-600 hover:text-blue-900">${log.proof_file_original}</a>
                                        </p>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }).join('');
                })
                .catch(error => {
                    document.getElementById('historyContent').innerHTML = `<p class="text-red-600">Error loading history: ${error.message}</p>`;
                });
        }

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        document.getElementById('historyModal').addEventListener('click', function(e) {
            if (e.target === this) closeHistoryModal();
        });
    </script>
</body>
</html>
