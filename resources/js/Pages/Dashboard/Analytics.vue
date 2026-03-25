<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900">Analytics Dashboard</h1>
        <p class="mt-2 text-gray-600">Analisis mendalam tentang progress digitalisasi</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Overview Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Entities Progress Chart -->
        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Progress per Entitas</h2>
          <div class="space-y-4">
            <div v-for="entity in entities" :key="entity.id" class="flex items-center justify-between">
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">{{ entity.name }}</p>
                <div class="w-full h-2 bg-gray-200 rounded-full mt-1 overflow-hidden">
                  <div :style="{ width: entity.average_progress + '%' }" class="h-full bg-indigo-500 transition-all"></div>
                </div>
              </div>
              <span class="ml-3 text-sm font-semibold text-gray-900">{{ entity.average_progress }}%</span>
            </div>
          </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Status</h2>
          <div class="space-y-3">
            <div v-for="status in statuses" :key="status.status" class="flex items-center justify-between">
              <div class="flex items-center space-x-2">
                <div :class="getStatusColor(status.status)" class="w-3 h-3 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700 capitalize">{{ status.status }}</span>
              </div>
              <span class="text-lg font-bold text-gray-900">{{ status.count }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Category Analytics -->
      <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Progress per Kategori</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="category in categories" :key="category.category" class="border rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">{{ category.category }}</h3>
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ Math.round(category.average_progress) }}%</div>
            <p class="text-sm text-gray-600">{{ category.total_count }} items</p>
            <div class="w-full h-2 bg-gray-200 rounded-full mt-2 overflow-hidden">
              <div :style="{ width: category.average_progress + '%' }" class="h-full bg-indigo-500"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    entities: Array,
    categories: Array,
    statuses: Array,
  },
  methods: {
    getStatusColor(status) {
      const colors = {
        pending: 'bg-gray-400',
        in_progress: 'bg-blue-500',
        completed: 'bg-green-500',
        delayed: 'bg-red-500',
      };
      return colors[status] || 'bg-gray-400';
    },
  },
};
</script>
