import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: '#254D70',
                secondary: '#EFE4D2',

                success: colors.emerald,
                warning: colors.amber,
                danger: colors.red,
                info: colors.blue,

                grayCustom: {
                    DEFAULT: '#6B7280',
                    50: '#F9FAFB',
                    100: '#F3F4F6',
                    200: '#E5E7EB',
                    400: '#9CA3AF',
                    500: '#6B7280',
                    600: '#4B5563',
                    700: '#374151',
                    800: '#1F2937',
                    900: '#111827',
                }
            },
        },
    },

    plugins: [forms],
};
