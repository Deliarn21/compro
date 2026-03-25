<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <Link href="/monitoring" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr; Kembali ke Entitas</Link>
        <h1 class="text-3xl font-bold text-gray-900">{{ entity.name }}</h1>
        <p class="mt-2 text-gray-600">{{ entity.description }}</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Entity Details -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Detail Card -->
        <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Entitas</h2>
          <dl class="space-y-4">
            <div class="flex justify-between">
              <dt class="text-gray-600 font-medium">Kode:</dt>
              <dd class="text-gray-900 font-semibold">{{ entity.code }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-gray-600 font-medium">Tipe:</dt>
              <dd>
                <span :class="{ 'bg-blue-100 text-blue-800': entity.type === 'department', 'bg-purple-100 text-purple-800': entity.type === 'pt' }" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                  {{ entity.type === 'pt' ? 'PT/Entitas' : 'Departemen' }}
                </span>
              </dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-gray-600 font-medium">Contact Person:</dt>
              <dd class="text-gray-900">{{ entity.contact_person || '-' }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-gray-600 font-medium">Email:</dt>
              <dd class="text-gray-900">{{ entity.contact_email || '-' }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-gray-600 font-medium">Telepon:</dt>
              <dd class="text-gray-900">{{ entity.contact_phone || '-' }}</dd>
            </div>
          </dl>
        </div>

        <!-- Progress Card -->
        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Progress Overview</h2>
          <div class="space-y-4">
            <div class="text-center">
              <div class="text-4xl font-bold text-indigo-600">
                {{ Math.round(items.reduce((sum, item) => sum + item.progress_actual, 0) / items.length || 0) }}%
              </div>
              <p class="text-gray-600 text-sm mt-1">Rata-rata Progress</p>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div :style="{ width: Math.round(items.reduce((sum, item) => sum + item.progress_actual, 0) / items.length || 0) + '%' }" class="h-full bg-indigo-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm">
              <div class="bg-gray-50 p-2 rounded">
                <p class="text-gray-600">Completed</p>
                <p class="text-lg font-bold text-green-600">{{ items.filter(i => i.progress_actual >= 100).length }}</p>
              </div>
              <div class="bg-gray-50 p-2 rounded">
                <p class="text-gray-600">Total</p>
                <p class="text-lg font-bold text-gray-900">{{ items.length }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Items Table -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Items Digitalisasi</h2>
          <p class="text-sm text-gray-600 mt-1">{{ items.length }} item untuk entitas ini</p>
        </div>

        <div v-if="items.length > 0" class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b-2 border-gray-200 bg-gray-50">
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Item</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Kategori</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Progress</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Status</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">PIC</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-4 px-6">
                  <div class="font-medium text-gray-900">{{ item.item_name }}</div>
                  <p class="text-sm text-gray-600">{{ item.description }}</p>
                </td>
                <td class="py-4 px-6">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ item.category }}
                  </span>
                </td>
                <td class="py-4 px-6">
                  <div class="flex items-center space-x-3">
                    <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                      <div :style="{ width: item.progress_actual + '%' }" class="h-full bg-indigo-500"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">{{ item.progress_actual }}%</span>
                  </div>
                </td>
                <td class="py-4 px-6">
                  <StatusBadge :status="item.status" />
                </td>
                <td class="py-4 px-6 text-gray-900">{{ item.assigned_to || '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="px-6 py-8 text-center">
          <p class="text-gray-600">Tidak ada item untuk entitas ini</p>
          <Link :href="route('monitoring.items.index')" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">
            Tambah Item Pertama
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import StatusBadge from '../Components/StatusBadge.vue';

export default {
  components: {
    Link,
    StatusBadge,
  },
  props: {
    entity: Object,
    items: Array,
  },
};
</script>
