/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{twig,html,js}", "./progs/**/*.{twig,html,js}"],
  theme: {
    extend: {
      fontSize: {
        tiny: ['0.65rem', '1.15rem']
      }
    },
  },
  plugins: [],
}
