/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php', // Adicione os caminhos dos seus arquivos Blade
        './resources/js/**/*.js', // Adicione os caminhos dos seus arquivos JS
        './resources/css/**/*.css', // Adicione os caminhos dos seus arquivos CSS
      ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    //require('flowbite/plugin'),
  ],
}

