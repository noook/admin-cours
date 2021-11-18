import { defineConfig } from 'windicss/helpers'

export default defineConfig({
  attributify: true,
  extract: {
    include: ['**/*.{vue,html,html.twig}'],
    exclude: ['node_modules', '.git', 'dist'],
  },
  theme: {
    extend: {
      colors: {
        black: {
          DEFAULT: '#000',
        },
      },
    },
  },
});
