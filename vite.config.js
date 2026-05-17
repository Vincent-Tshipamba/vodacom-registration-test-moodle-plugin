import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        outDir: 'assets/build',
        emptyOutDir: false,
        rollupOptions: {
            input: 'assets/js/main.js',
            output: {
                entryFileNames: 'app.js',
            },
        },
    }
})