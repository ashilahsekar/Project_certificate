/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "src/**/*.{php,html}",
    "src/index.html",
    "node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
    require('flowbite/plugin')
  ],
  darkMode: 'selector',
}

