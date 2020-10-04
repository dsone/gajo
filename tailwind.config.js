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
		},

		opacity: {
			'0': '0',
			'25': '0.25',
			'50': '0.5',
			'75': '0.75',
			'80': '0.8',
			'90': '0.9',
			'95': '0.95',
			'100': '1',
		},

	},
  },
  variants: {},
  plugins: [
	  require('@tailwindcss/custom-forms')
  ],
}
