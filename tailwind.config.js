module.exports = {
  content: [
    './templates/**/*.php',
    '/**/*.php',
    './classes/**/*.php',
    './lang/**/*.php',
    './node_modules/flowbite/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
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
