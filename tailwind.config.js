module.exports = {
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true
  },
  purge: [],
  theme: {
    extend: {

		colors: {
			primary: {
				50: '#F5F6F7',
				100: '#EBEDEF',
				200: '#CCD2D7',
				300: '#AEB6BF',
				400: '#71808E',
				500: '#34495E',
				600: '#2F4255',
				700: '#1F2C38',
				800: '#17212A',
				900: '#10161C',
			},
		}

	},
  },
  variants: {},
  plugins: [
	  require('@tailwindcss/custom-forms')
  ],
}
