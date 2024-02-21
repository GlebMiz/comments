module.exports = {
    root: true,
    env: {
        node: true,
    },
    parser: 'vue-eslint-parser',
    parserOptions: {
        parser: '@typescript-eslint/parser',
        ecmaVersion: 2020,
        sourceType: 'module',
        extraFileExtensions: ['.vue'],
    },
    extends: [
        'plugin:vue/vue3-recommended',
        'eslint:recommended',
        '@vue/typescript/recommended',
        "plugin:@typescript-eslint/recommended"
    ],
    plugins: ['@typescript-eslint'],
    rules: {
        'vue/html-indent': 'off',
        'vue/multi-word-component-names': 'off',
        'vue/max-attributes-per-line': 'off',
        'vue/html-closing-bracket-newline': 'off',
        'vue/first-attribute-linebreak' : 'off',
        'vue/singleline-html-element-content-newline' : 'off',
        'vue/multiline-html-element-content-newline' : 'off',
    },
};
