<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900">Digitalisasi Monitoring Dashboard</h1>
        <p class="mt-2 text-gray-600">Pantau progress digitalisasi berbagai departemen dan entitas</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <StatCard title="Total Progress" :value="`${statistics.total_progress}%`" icon="chart" color="blue" />
        <StatCard title="Total Items" :value="statistics.total_items" icon="inbox" color="indigo" />
        <StatCard title="Komplet" :value="statistics.completed_items" icon="check" color="green" />
        <StatCard title="In Progress" :value="statistics.in_progress_items" icon="clock" color="yellow" />
        <StatCard title="Delayed" :value="statistics.delayed_items" icon="alert" color="red" />
      </div>

      <!-- Filters -->
      <div class="bg-white p-4 rounded-lg shadow mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Entitas</label>
            <select v-model="selectedEntity" @change="updateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="">Semua Entitas</option>
              <option v-for="entity in entities" :key="entity.id" :value="entity.id">
                {{ entity.name }} ({{ entity.average_progress }}%)
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select v-model="selectedStatus" @change="updateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="">Semua Status</option>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="delayed">Delayed</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select v-model="selectedCategory" @change="updateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="">Semua Kategori</option>
              <option v-for="category in categories" :key="category" :value="category">
                {{ category }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Entities Progress Overview -->
      <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Progress Entitas</h2>
        <div class="space-y-6">
          <div v-for="entity in entities" :key="entity.id" class="border-l-4 border-indigo-500 pl-4">
            <div class="flex justify-between items-center mb-2">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ entity.name }}</h3>
                <p class="text-sm text-gray-600">{{ entity.type | capitalize }} • Kode: {{ entity.code }}</p>
              </div>
              <div class="text-right">
                <span class="text-2xl font-bold text-indigo-600">{{ entity.average_progress }}%</span>
                <p class="text-sm text-gray-600">{{ entity.completed_items }}/{{ entity.total_items }} items</p>
              </div>
            </div>
            <!-- Progress Bar -->
            <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
              <div :style="{ width: entity.average_progress + '%' }" class="h-full bg-indigo-500 transition-all duration-300"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Items Table -->
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold text-gray-900">Daftar Items</h2>
          <Link :href="route('monitoring.items.index')" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
            + Tambah Item
          </Link>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b-2 border-gray-200">
                <th class="text-left py-3 px-4 font-semibold text-gray-900">Item</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-900">Entitas</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-900">Kategori</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-900">Progress</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-900">Status</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-900">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items.data" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-3 px-4">{{ item.item_name }}</td>
                <td class="py-3 px-4">{{ item.entity.name }}</td>
                <td class="py-3 px-4">{{ item.category }}</td>
                <td class="py-3 px-4">
                  <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div :style="{ width: item.progress_actual + '%' }" class="h-full bg-indigo-500"></div>
                  </div>
                  <span class="text-sm text-gray-600">{{ item.progress_actual }}%</span>
                </td>
                <td class="py-3 px-4">
                  <StatusBadge :status="item.status" />
                </td>
                <td class="py-3 px-4">
                  <Link :href="route('monitoring.items.edit', item.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
          <p class="text-sm text-gray-600">Menampilkan {{ items.from }} hingga {{ items.to }} dari {{ items.total }} items</p>
          <div class="flex space-x-2">
            <Link v-for="link in items.links" :key="link.url" v-if="link.url" :href="link.url" :class="{ 'bg-indigo-600 text-white': link.active, 'bg-white text-gray-900': !link.active }" class="px-3 py-2 border border-gray-300 rounded-md transition">
              {{ link.label.includes('&') ? 'Prev' : link.label.includes('&') ? 'Next' : link.label }}
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import StatCard from '../Components/StatCard.vue';
import StatusBadge from '../Components/StatusBadge.vue';

export default {
  components: {
    Link,
    StatCard,
    StatusBadge,
  },
  props: {
    entities: Array,
    items: Object,
    statistics: Object,
    categories: Array,
    filters: Object,
  },
  data() {
    return {
      selectedEntity: this.filters.entity || '',
      selectedStatus: this.filters.status || '',
      selectedCategory: this.filters.category || '',
    };
  },
  methods: {
    updateFilter() {
      const params = new URLSearchParams();
      if (this.selectedEntity) params.append('entity', this.selectedEntity);
      if (this.selectedStatus) params.append('status', this.selectedStatus);
      if (this.selectedCategory) params.append('category', this.selectedCategory);
      
      window.location.href = `${route('monitoring.dashboard')}?${params.toString()}`;
    },
  },
  filters: {
    capitalize(value) {
      if (!value) return '';
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
};
</script>
