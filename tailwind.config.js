/** @type {import('tailwindcss').Config} */
const flowbite = require('flowbite/plugin');


module.exports = {
  content: ["./HOMEPAGE/*.{html,js}","./node_modules/flowbite/**/*.js"],

  theme: {
    extend: {},
  },
  plugins: [
    flowbite
  ],
}

module.exports = {

  content: [
        './node_modules/flowbite/**/*.js'
  ],
    plugins: [
        require('flowbite/plugin')
  ]

}

