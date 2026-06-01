const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './admin/**/*.php',
    './templates/**/*.php',
    './index.php',
    './apply.php',
    './classes/**/*.php',
    './lang/**/*.php',
    './assets/**/*.js',
    './node_modules/preline/dist/*.js',
    './node_modules/flowbite/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        custom: {
          50: colors.blue[50],
          100: colors.blue[100],
          200: colors.blue[200],
          300: colors.blue[300],
          400: colors.blue[400],
          500: colors.blue[500], // Using Tailwind's color palette
          600: colors.blue[600],
          700: colors.blue[700],
          800: colors.blue[800],
          900: colors.blue[900],
          950: colors.blue[950],
        },
        scholarship: {
          red: '#dc2626',
          rose: '#f43f5e',
          slate: '#0f172a',
          ink: '#111827'
        }
      },
      boxShadow: {
        scholarship: '0 24px 60px rgba(15, 23, 42, 0.12)'
      },
      borderRadius: {
        scholarship: '2rem'
      }
    }
  },
  plugins: [
    require('flowbite/plugin')
  ]
};
