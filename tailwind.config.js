/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    colors: {
      'primary': '#D87D4A',
      'primary-light': '#fbaf85',
      'danger': '#CD2C2C',
      'neutral-lightest': '#ffffff',
      'neutral-lighter': '#FAFAFA',
      'neutral-light': '#F1F1F1',
      'neutral-darker': '#101010',
      'neutral-darkest': '#000000',
    },
    screens: {
      'sm': '641px',
      'md': '769px',
    },
    extend: {},
  },
  plugins: [],
}
