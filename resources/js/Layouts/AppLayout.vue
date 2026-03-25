<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center space-x-8">
            <Link href="/monitoring" class="text-xl font-bold hover:text-indigo-100">
              📊 Digitalisasi
            </Link>
            <div class="hidden md:flex space-x-1">
              <Link href="/monitoring" :class="{ 'bg-indigo-700': isActive('monitoring.dashboard'), 'hover:bg-indigo-500': !isActive('monitoring.dashboard') }" class="px-3 py-2 rounded-md text-sm font-medium transition">
                Dashboard
              </Link>
              <Link href="/monitoring/entities" :class="{ 'bg-indigo-700': isActive('monitoring.entities'), 'hover:bg-indigo-500': !isActive('monitoring.entities') }" class="px-3 py-2 rounded-md text-sm font-medium transition">
                Entitas
              </Link>
              <Link href="/monitoring/items" :class="{ 'bg-indigo-700': isActive('monitoring.items'), 'hover:bg-indigo-500': !isActive('monitoring.items') }" class="px-3 py-2 rounded-md text-sm font-medium transition">
                Items
              </Link>
              <Link href="/monitoring/analytics" :class="{ 'bg-indigo-700': isActive('monitoring.analytics'), 'hover:bg-indigo-500': !isActive('monitoring.analytics') }" class="px-3 py-2 rounded-md text-sm font-medium transition">
                Analytics
              </Link>
            </div>
          </div>

          <div v-if="$page.props.auth.user" class="flex items-center space-x-4">
            <span class="text-sm">{{ $page.props.auth.user.name }}</span>
            <form method="POST" action="/admin/logout" @submit.prevent="logout" class="inline">
              <input type="hidden" name="_method" value="POST" />
              <input type="hidden" name="_token" :value="$page.props.csrf_token" />
              <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-500 transition">
                Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div v-if="$page.props.flash.success" class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
      <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md">
        {{ $page.props.flash.success }}
      </div>
    </div>

    <div v-if="$page.props.flash.error" class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
      <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md">
        {{ $page.props.flash.error }}
      </div>
    </div>

    <!-- Page Content -->
    <slot />
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
  setup() {
    const page = usePage();
    
    return {
      $page: page,
    };
  },
  methods: {
    isActive(route) {
      return this.$page.url.includes(route.split('.')[0]);
    },
    logout() {
      const form = document.querySelector('form');
      if (form) {
        form.submit();
      }
    },
  },
};
</script>
