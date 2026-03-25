<template>
  <span :class="badgeClasses" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
    {{ statusLabel }}
  </span>
</template>

<script>
export default {
  props: {
    status: {
      type: String,
      required: true,
    },
  },
  computed: {
    statusLabel() {
      const labels = {
        pending: 'Pending',
        in_progress: 'In Progress',
        completed: 'Completed',
        delayed: 'Delayed',
      };
      return labels[this.status] || this.status;
    },
    badgeClasses() {
      const classes = {
        pending: 'bg-gray-100 text-gray-800',
        in_progress: 'bg-blue-100 text-blue-800',
        completed: 'bg-green-100 text-green-800',
        delayed: 'bg-red-100 text-red-800',
      };
      return classes[this.status] || 'bg-gray-100 text-gray-800';
    },
  },
};
</script>
