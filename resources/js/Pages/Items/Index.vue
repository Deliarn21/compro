<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Items</h1>
            <p class="mt-2 text-gray-600">Kelola item digitalisasi dari berbagai departemen</p>
          </div>
          <button @click="showCreateModal = true" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
            + Tambah Item Baru
          </button>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Filters -->
      <div class="bg-white p-4 rounded-lg shadow mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Entitas</label>
            <select v-model="selectedEntityFilter" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="">Semua Entitas</option>
              <option v-for="entity in entities" :key="entity.id" :value="entity.id">
                {{ entity.name }}
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
            <select v-model="selectedStatusFilter" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="">Semua Status</option>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="delayed">Delayed</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
            <select v-model="selectedCategoryFilter" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="">Semua Kategori</option>
              <option v-for="category in categories" :key="category" :value="category">
                {{ category }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Items Table -->
      <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b-2 border-gray-200 bg-gray-50">
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Item</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Entitas</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Kategori</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Progress</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Status</th>
                <th class="text-left py-4 px-6 font-semibold text-gray-900">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items.data" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-4 px-6">
                  <div class="font-medium text-gray-900">{{ item.item_name }}</div>
                  <p class="text-sm text-gray-600">{{ item.description }}</p>
                </td>
                <td class="py-4 px-6">{{ item.entity.name }}</td>
                <td class="py-4 px-6">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ item.category }}
                  </span>
                </td>
                <td class="py-4 px-6">
                  <div class="flex items-center space-x-3">
                    <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                      <div :style="{ width: item.progress_actual + '%' }" class="h-full bg-indigo-500"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-900">{{ item.progress_actual }}%</span>
                  </div>
                </td>
                <td class="py-4 px-6">
                  <StatusBadge :status="item.status" />
                </td>
                <td class="py-4 px-6">
                  <button @click="editItem(item)" class="text-indigo-600 hover:text-indigo-900 mr-3 text-sm font-medium">Edit</button>
                  <button @click="deleteItem(item.id)" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 flex justify-between items-center border-t border-gray-200">
          <p class="text-sm text-gray-600">Menampilkan {{ items.from }} hingga {{ items.to }} dari {{ items.total }} items</p>
          <div class="flex space-x-2">
            <Link v-for="link in items.links" :key="link.url" v-if="link.url" :href="link.url" :class="{ 'bg-indigo-600 text-white': link.active, 'bg-white text-gray-900 border border-gray-300': !link.active }" class="px-3 py-2 rounded-md transition text-sm">
              {{ link.label }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900">{{ isEditing ? 'Edit Item' : 'Tambah Item Baru' }}</h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <form @submit.prevent="submitForm" class="p-6 space-y-6">
          <!-- Entity Selection -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Entitas *</label>
            <select v-model="form.entity_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required>
              <option value="">Pilih Entitas</option>
              <option v-for="entity in entities" :key="entity.id" :value="entity.id">
                {{ entity.name }}
              </option>
            </select>
            <p v-if="errors.entity_id" class="text-red-600 text-sm mt-1">{{ errors.entity_id }}</p>
          </div>

          <!-- Item Name -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Item *</label>
            <input v-model="form.item_name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required placeholder="Misal: Implementasi SAP" />
            <p v-if="errors.item_name" class="text-red-600 text-sm mt-1">{{ errors.item_name }}</p>
          </div>

          <!-- Category -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
            <input v-model="form.category" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required placeholder="Misal: Hardware, Software, Process" />
            <p v-if="errors.category" class="text-red-600 text-sm mt-1">{{ errors.category }}</p>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea v-model="form.description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" rows="3" placeholder="Deskripsi detail item..."></textarea>
          </div>

          <!-- Progress -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Progress Actual (%)</label>
              <input v-model.number="form.progress_actual" type="number" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required />
              <p v-if="errors.progress_actual" class="text-red-600 text-sm mt-1">{{ errors.progress_actual }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Progress Target (%)</label>
              <input v-model.number="form.progress_target" type="number" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required />
              <p v-if="errors.progress_target" class="text-red-600 text-sm mt-1">{{ errors.progress_target }}</p>
            </div>
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select v-model="form.status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500">
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="delayed">Delayed</option>
            </select>
          </div>

          <!-- Dates -->
          <div class="grid grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
              <input v-model="form.start_date" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Target Date</label>
              <input v-model="form.target_date" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Completion Date</label>
              <input v-model="form.completion_date" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" />
            </div>
          </div>

          <!-- Assigned To -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">PIC (Person In Charge)</label>
            <input v-model="form.assigned_to" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" placeholder="Nama PIC..." />
          </div>

          <!-- Notes -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea v-model="form.notes" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" rows="2" placeholder="Catatan atau observasi..."></textarea>
          </div>

          <!-- Buttons -->
          <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <button type="button" @click="closeModal" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
              Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition" :disabled="isSubmitting">
              {{ isSubmitting ? 'Menyimpan...' : isEditing ? 'Perbarui' : 'Tambah' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import StatusBadge from '../Components/StatusBadge.vue';
import axios from 'axios';

export default {
  components: {
    Link,
    StatusBadge,
  },
  props: {
    items: Object,
    entities: Array,
    categories: Array,
    filters: Object,
  },
  data() {
    return {
      showCreateModal: false,
      isEditing: false,
      isSubmitting: false,
      errors: {},
      selectedEntityFilter: this.filters.entity_id || '',
      selectedStatusFilter: this.filters.status || '',
      selectedCategoryFilter: this.filters.category || '',
      form: {
        entity_id: '',
        item_name: '',
        category: '',
        description: '',
        progress_actual: 0,
        progress_target: 100,
        status: 'pending',
        start_date: '',
        target_date: '',
        completion_date: '',
        assigned_to: '',
        notes: '',
      },
      currentItemId: null,
    };
  },
  methods: {
    editItem(item) {
      this.isEditing = true;
      this.currentItemId = item.id;
      this.form = { ...item };
      this.showCreateModal = true;
    },
    deleteItem(itemId) {
      if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        axios.delete(route('monitoring.items.destroy', itemId)).then(() => {
          window.location.reload();
        });
      }
    },
    closeModal() {
      this.showCreateModal = false;
      this.isEditing = false;
      this.currentItemId = null;
      this.errors = {};
      this.form = {
        entity_id: '',
        item_name: '',
        category: '',
        description: '',
        progress_actual: 0,
        progress_target: 100,
        status: 'pending',
        start_date: '',
        target_date: '',
        completion_date: '',
        assigned_to: '',
        notes: '',
      };
    },
    submitForm() {
      this.isSubmitting = true;
      this.errors = {};

      const url = this.isEditing 
        ? route('monitoring.items.update', this.currentItemId)
        : route('monitoring.items.store');
      
      const method = this.isEditing ? 'put' : 'post';

      axios({
        method,
        url,
        data: this.form,
      })
        .then(() => {
          window.location.reload();
        })
        .catch((error) => {
          if (error.response && error.response.data.errors) {
            this.errors = error.response.data.errors;
          }
          this.isSubmitting = false;
        });
    },
    applyFilters() {
      const params = new URLSearchParams();
      if (this.selectedEntityFilter) params.append('entity_id', this.selectedEntityFilter);
      if (this.selectedStatusFilter) params.append('status', this.selectedStatusFilter);
      if (this.selectedCategoryFilter) params.append('category', this.selectedCategoryFilter);
      
      window.location.href = `${route('monitoring.items.index')}?${params.toString()}`;
    },
  },
};
</script>
