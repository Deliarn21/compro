<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Entitas</h1>
            <p class="mt-2 text-gray-600">Kelola departemen dan PT/Entitas yang terlibat dalam digitalisasi</p>
          </div>
          <button @click="showCreateModal = true" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
            + Tambah Entitas
          </button>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Entities Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div v-for="entity in entities.data" :key="entity.id" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">{{ entity.name }}</h3>
              <p class="text-sm text-gray-600 mt-1">{{ entity.code }}</p>
            </div>
            <span :class="{ 'bg-blue-100 text-blue-800': entity.type === 'department', 'bg-purple-100 text-purple-800': entity.type === 'pt' }" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
              {{ entity.type }}
            </span>
          </div>

          <p v-if="entity.description" class="text-gray-600 text-sm mb-4">{{ entity.description }}</p>

          <div class="grid grid-cols-2 gap-4 mb-4 py-4 border-t border-b border-gray-200">
            <div>
              <p class="text-sm text-gray-600">Total Items</p>
              <p class="text-2xl font-bold text-gray-900">{{ entity.digitalization_items_count }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Progress Avg</p>
              <p class="text-2xl font-bold text-indigo-600">{{ entity.average_progress }}%</p>
            </div>
          </div>

          <div class="flex space-x-2">
            <button @click="editEntity(entity)" class="flex-1 px-3 py-2 text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition text-sm font-medium">
              Edit
            </button>
            <button @click="deleteEntity(entity.id)" class="flex-1 px-3 py-2 text-red-600 bg-red-50 rounded-md hover:bg-red-100 transition text-sm font-medium">
              Hapus
            </button>
            <Link :href="route('monitoring.entities.show', entity.id)" class="flex-1 px-3 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition text-sm font-medium">
              Detail
            </Link>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="entities.links && entities.links.length > 3" class="flex justify-center space-x-2 mb-8">
        <Link v-for="link in entities.links" :key="link.url" v-if="link.url" :href="link.url" :class="{ 'bg-indigo-600 text-white': link.active, 'bg-white text-gray-900 border border-gray-300': !link.active }" class="px-3 py-2 rounded-md transition">
          {{ link.label }}
        </Link>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg max-w-xl w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900">{{ isEditing ? 'Edit Entitas' : 'Tambah Entitas Baru' }}</h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <form @submit.prevent="submitForm" class="p-6 space-y-6">
          <!-- Name -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Entitas *</label>
            <input v-model="form.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required placeholder="Misal: PE Maju Jaya" />
            <p v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name }}</p>
          </div>

          <!-- Code -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kode *</label>
            <input v-model="form.code" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required placeholder="Misal: PE001" />
            <p v-if="errors.code" class="text-red-600 text-sm mt-1">{{ errors.code }}</p>
          </div>

          <!-- Type -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe *</label>
            <select v-model="form.type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" required>
              <option value="">Pilih Tipe</option>
              <option value="department">Departemen</option>
              <option value="pt">PT/Entitas</option>
            </select>
            <p v-if="errors.type" class="text-red-600 text-sm mt-1">{{ errors.type }}</p>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea v-model="form.description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" rows="3" placeholder="Deskripsi entitas..."></textarea>
          </div>

          <!-- Contact Person -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kontak</label>
            <input v-model="form.contact_person" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" placeholder="Nama contact person..." />
          </div>

          <!-- Contact Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
            <input v-model="form.contact_email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" placeholder="email@example.com" />
            <p v-if="errors.contact_email" class="text-red-600 text-sm mt-1">{{ errors.contact_email }}</p>
          </div>

          <!-- Contact Phone -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
            <input v-model="form.contact_phone" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500" placeholder="08123456789" />
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
import axios from 'axios';

export default {
  components: {
    Link,
  },
  props: {
    entities: Object,
  },
  data() {
    return {
      showCreateModal: false,
      isEditing: false,
      isSubmitting: false,
      errors: {},
      currentEntityId: null,
      form: {
        name: '',
        code: '',
        type: '',
        description: '',
        contact_person: '',
        contact_email: '',
        contact_phone: '',
      },
    };
  },
  methods: {
    editEntity(entity) {
      this.isEditing = true;
      this.currentEntityId = entity.id;
      this.form = { ...entity };
      this.showCreateModal = true;
    },
    deleteEntity(entityId) {
      if (confirm('Apakah Anda yakin ingin menghapus entitas ini? Data items terkait akan ikut dihapus.')) {
        axios.delete(route('monitoring.entities.destroy', entityId)).then(() => {
          window.location.reload();
        });
      }
    },
    closeModal() {
      this.showCreateModal = false;
      this.isEditing = false;
      this.currentEntityId = null;
      this.errors = {};
      this.form = {
        name: '',
        code: '',
        type: '',
        description: '',
        contact_person: '',
        contact_email: '',
        contact_phone: '',
      };
    },
    submitForm() {
      this.isSubmitting = true;
      this.errors = {};

      const url = this.isEditing 
        ? route('monitoring.entities.update', this.currentEntityId)
        : route('monitoring.entities.store');
      
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
  },
};
</script>
