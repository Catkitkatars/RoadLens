import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    hash: false,
    target: 'esnext',
    outDir: 'public/dist',
    assetsDir: 'public/dist/assets',
    rollupOptions: {
      input: {
        edit: './resources/js/edit.js', 
        home: './resources/js/home.js', 
        styles: './resources/css/app.css',
      },
      output: {
        entryFileNames: `js/[name].js`,
        chunkFileNames: `js/[name].js`,
        assetFileNames: `css/[name].[ext]`
      },
    },
  },
});
