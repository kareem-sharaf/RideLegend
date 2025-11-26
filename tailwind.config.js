/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // نظام الألوان الجديد - CycleExchange Style
        black: {
          DEFAULT: '#000000',
        },
        gray: {
          dark: '#1A1A1A',
          light: '#F5F5F5',
        },
        gold: {
          DEFAULT: '#D1A954',
          light: '#E8D4A8',
        },
        // الألوان المحايدة المحدثة
        neutral: {
          50: '#FAFAFA',
          100: '#F5F5F5',
          200: '#E5E5E5',
          300: '#D4D4D4',
          400: '#A3A3A3',
          500: '#737373',
          600: '#525252',
          700: '#404040',
          800: '#262626',
          900: '#1A1A1A',
          950: '#0A0A0A',
        },
        // الألوان الثانوية (للحالات الخاصة)
        accent: {
          green: '#10B981',
          orange: '#F59E0B',
          red: '#EF4444',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
        display: ['Playfair Display', 'serif'],
      },
      fontSize: {
        // Typography Hierarchy محسّن
        'display-2xl': ['4.5rem', { lineHeight: '1.1', letterSpacing: '-0.02em' }],
        'display-xl': ['3.75rem', { lineHeight: '1.1', letterSpacing: '-0.02em' }],
        'display-lg': ['3rem', { lineHeight: '1.2', letterSpacing: '-0.01em' }],
        'display-md': ['2.25rem', { lineHeight: '1.2', letterSpacing: '-0.01em' }],
        'display-sm': ['1.875rem', { lineHeight: '1.3' }],
      },
      spacing: {
        // مسافات واسعة للتصميم النظيف
        'section': '5rem', // py-20
        'hero': '6rem', // py-24
        'card': '2rem', // p-8
      },
      borderRadius: {
        'card': '0px', // بطاقات مسطحة
        'button': '0px', // أزرار minimal
      },
      boxShadow: {
        // إزالة الظلال - تصميم minimal
        'none': 'none',
      },
      borderWidth: {
        '1': '1px',
      },
    },
  },
  plugins: [],
}

