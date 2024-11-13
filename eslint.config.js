import js from '@eslint/js';
import globals from 'globals';
import vue from 'eslint-plugin-vue';

export default [
    js.configs.recommended,
    {
        files: ['**/*.{js,jsx,mjs,cjs,vue}'],
        ignores: ['public/js/**', 'dist/**', 'node_modules/**'],
        plugins: {
        vue
        },
        languageOptions: {
        ecmaVersion: 2020,
        sourceType: 'module',
        parser: vue.parser,
        globals: {
            ...globals.browser,
            Vue: true,
            jQuery: true,
            $: true
        }
        },
        rules: {
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-unused-vars': ['warn', {
            varsIgnorePattern: '^_|^\\$|exports|__webpack_require__'
        }],
        'vue/multi-word-component-names': 'off',
        'no-undef': 'warn'
        }
    }
];