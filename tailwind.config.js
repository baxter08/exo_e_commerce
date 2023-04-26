/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./templates/**/*.html.twig',
    './node_modules/tw-elements/dist/js/**/*.js',
  ],
  theme: {
    colors: {
      indigo: '#5c6ac4',
      blue: '#007ace',
      red: '#de3618',
      gray: {
        '100': '#f5f5f5',
        '200': '#eeeeee',
        '300': '#e0e0e0',
        '400': '#bdbdbd',
        '500': '#9e9e9e',
        '600': '#757575',
        '700': '#616161',
        '800': '#424242',
        '900': '#212121',
      }
    },
    extend: {},
  },
  plugins: [require("tw-elements/dist/plugin")],
}