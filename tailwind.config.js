// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme'

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1E3A8A',    // azul oscuro
        secondary: '#F59E0B',  // ámbar
        accent: '#10B981',     // verde esmeralda
        background: '#F3F4F6', // gris claro
        text: '#374151',       // gris oscuro
      },
      fontFamily: {
        sans: ['"Inter"', ...defaultTheme.fontFamily.sans],
        display: ['"Poppins"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
