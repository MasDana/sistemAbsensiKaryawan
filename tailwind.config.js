/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      boxShadow: {
        'right': '4px 0 10px rgba(0, 0, 0, 0.1)',  
      },
    },
  },
  plugins: [],
}

