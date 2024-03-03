import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    target: 'esnext',
    outDir: 'public/dist',
    assetsDir: 'public/dist/assets',
    rollupOptions: {
      input: {
        main: './resources/js/main.js', 
        styles: './resources/css/app.css',
      },
      output: {
        entryFileNames: 'js/app.js', 
        assetFileNames: 'css/app.css', 
      },
    },
  },
});
