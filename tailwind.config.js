/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./src/Twig/**/*.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        times: ["Times New Roman", "Times", "serif"],
        poppins: ["Poppins", "sans-serif"],
      },
    },
  },
  plugins: ["prettier-plugin-tailwindcss"],
};
