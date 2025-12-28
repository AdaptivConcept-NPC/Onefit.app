import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    proxy: {
      '/scripts': {
        target: 'http://localhost:81/Onefit.app',
        changeOrigin: true,
        secure: false,
      },
      '/administration': {
        target: 'http://localhost:81/Onefit.app',
        changeOrigin: true,
        secure: false,
      },
      '/backend': {
        target: 'http://localhost:81/Onefit.app',
        changeOrigin: true,
        secure: false,
      }
    }
  }
})
