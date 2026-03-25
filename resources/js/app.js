import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

createInertiaApp({
  resolve: (name) => resolvePageComponent(
    `./Pages/${name}.vue`,
    import.meta.glob('./Pages/**/*.vue'),
  ),
  setup({ el, App, props, plugin }) {
    createApp({
      render: () => h(App, props),
    })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .mount(el);
  },
  progress: {
    color: '#4F46E5',
  },
});

