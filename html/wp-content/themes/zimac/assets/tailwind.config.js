const colors = require("tailwindcss/colors");
module.exports = {
	important: "body[class]",
	// important: true,
	mode: "jit",
	purge: {
		content: [
			"scripts/*.js",
			//
			"../template-parts/**/**/*.php",
			"../app/Comment/Controllers/*.php",
			"../app/Widget/Controllers/*.php",
			"../searchwp-live-ajax-search/**/**/*.php",
			"../*.php",
			//	--- Quet len cac file php tren plugins
			"../../../plugins/hsblog2-shortcodes/app/Controllers/**/**/*.php",
			"../../../plugins/hsblog2-shortcodes/app/Widgets/**/**/*.php",
		],
		options: {
			safelist: [
				/^grid-cols-/,
				/^sm:grid-cols-/,
				/^md:grid-cols-/,
				/^lg:grid-cols-/,
				/^xl:grid-cols-/,
				//
				/^gap-/,
				/^sm:gap-/,
				/^md:gap-/,
				/^lg:gap-/,
				/^xl:gap-/,
				//
			],
		},
	},
	darkMode: "class", // or 'media' or 'class'
	theme: {
		container: {
			center: true,
			padding: {
				DEFAULT: "10px",
				"2xl": "128px",
			},
		},
		fontFamily: {
			display: ["DMSans", "system-ui", "sans-serif"],
			body: ["DMSans", "system-ui", "sans-serif"],
			Merriweather: ["Merriweather", "system-ui", "sans-serif"],
			LineAwesome: ["Line Awesome Free", "system-ui", "sans-serif"],
		},

		colors: {
			...colors,
			transparent: "transparent",
			current: "currentColor",
			primary: "#FFDCBE",
			secondary: "#8DFFD2",
			tertiary: "#F57171",
			quateary: "#311695",
			facebook: "#325D94",
			googlePlus: "#DF2E1C",
			twitter: "#00AADB",
			black: "#000",
			white: "#fff",
			gray: {
				100: "#F7F6F9",
				200: "#F0F0F2",
				300: "#ECEBEE",
				400: "#DBDADE",
				500: "#BDBBC4",
				600: "#7B778D",
				700: "#3D3753",
				800: "#281C55",
				900: "#1B113E",
			},
		},
		extend: {
			maxWidth: {
				body: "680px",
			},
			outline: {
				primary: ["2px solid #FFDCBE", "2px"],
				secondary: ["2px solid #2DDE98", "2px"],
			},
			borderColor: {
				primary: "#FFDCBE",
				secondary: "#2DDE98",
				tertiary: "#F57171",
				quateary: "#311695",
				black: "#000",
				white: "#fff",
			},
			boxShadow: {
				myShadow1: "0 5px 20px 0 rgba(27,17,62, 0.1)",
			},
			zIndex: {
				"-1": "-1",
				max: 2147483647,
			},
			spacing: {
				22: "5.5rem",
				42: "10.5rem",
				46: "11.5rem",
			},
			borderWidth: {
				3: "3px",
				5: "5px",
				6: "6px",
			},

			borderRadius: {
				xl: "0.625rem",
				"1.5xl": "0.75rem",
				"2.5xl": "1.375rem",
				"4xl": "1.875rem",
				"3.125rem": "3.125rem",
			},
			margin: {
				13: "3.125rem",
				//
				"1px": "1px",
				"2px": "2px",
				"3px": "3px",
				"14px": "14px",
				"10px": "10px",
				"-1px": "-1px",
				"-2px": "-2px",
				"-3px": "-3px",
			},
			padding: {
				3.5: "0.8125rem",
				13: "3.125rem",
				//
				"1px": "1px",
				"2px": "2px",
				"3px": "3px",
				"14px": "14px",
				"10px": "10px",
				//
				"53.8%": "53.8%",
				"56.25%": "56.25%",
				"177.77%": "177.77%",
				"75%": "75%",
				"133.33%": "133.33%",
				"66.6%": "66.6%",
				"150%": "150%",
				"62.5%": "62.5%",
				"160%": "160%",
				"71.42%": "71.42%",
				"140%": "140%",
				"100%": "100%",
			},
			fontSize: {
				sm: ["0.8125rem", "1.063rem"],
				base: ["0.875rem", "1.5rem"],
				body: ["1rem", "1.6875rem"],
				h1: ["2.25rem", "2.9375rem"],
				h2: ["2rem", "2.5rem"],
				h3: ["1.75rem", "2.3125rem"],
				h4: ["1.5rem", "1.9375rem"],
				h5: ["1.25rem", "1.625rem"],
				h6: ["1rem", "1.3125rem"],
				//
				"1.375rem": ["1.375rem", "1.82rem"],
				//
				"4.5xl": ["2.75rem", "3.25rem"],
			},
		},
	},
	variants: {
		extend: {},
	},
	plugins: [
		require("@tailwindcss/forms"),
		require("@tailwindcss/aspect-ratio"),
		require("@tailwindcss/typography"),
		require("@tailwindcss/line-clamp"),
	],
};
