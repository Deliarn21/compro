<template>
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-600 text-sm font-medium">{{ title }}</p>
        <p v-if="typeof value === 'number'" class="text-3xl font-bold text-gray-900 mt-2">{{ value }}</p>
        <p v-else class="text-3xl font-bold text-gray-900 mt-2">{{ value }}</p>
      </div>
      <div :class="colorClasses" class="p-3 rounded-lg">
        <component :is="iconComponent" class="w-6 h-6 text-white" />
      </div>
    </div>
  </div>
</template>

<script>
import { MagnifyingGlassChartIcon, InboxIcon, CheckCircleIcon, ClockIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/solid';

export default {
  components: {
    MagnifyingGlassChartIcon,
    InboxIcon,
    CheckCircleIcon,
    ClockIcon,
    ExclamationTriangleIcon,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    value: {
      type: [String, Number],
      required: true,
    },
    icon: {
      type: String,
      default: 'chart',
    },
    color: {
      type: String,
      default: 'blue',
    },
  },
  computed: {
    colorClasses() {
      const colors = {
        blue: 'bg-blue-500',
        indigo: 'bg-indigo-500',
        green: 'bg-green-500',
        yellow: 'bg-yellow-500',
        red: 'bg-red-500',
      };
      return colors[this.color] || colors.blue;
    },
    iconComponent() {
      const icons = {
        chart: 'MagnifyingGlassChartIcon',
        inbox: 'InboxIcon',
        check: 'CheckCircleIcon',
        clock: 'ClockIcon',
        alert: 'ExclamationTriangleIcon',
      };
      return icons[this.icon] || 'MagnifyingGlassChartIcon';
    },
  },
};
</script>
