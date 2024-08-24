import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"

export default defineConfig({
  server: {
    port: 5173,
    hmr: {
      host: "localhost",
    },
  },
  plugins: [
    laravel({
      input: [
        // javascript
        "resources/js/laws/compliance_chart.js",
        // stylesheets
        "resources/sass/app.scss",
      ],
      refresh: true,
    }),
  ],
})
