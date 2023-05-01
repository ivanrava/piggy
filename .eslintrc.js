/* eslint-env node */
module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
    ],
    parser: "vue-eslint-parser",
    parserOptions: {
        "parser": "@typescript-eslint/parser",
        sourceType: "module"
    },
    rules: {
        // override/add rules settings here, such as:
        // 'vue/no-unused-vars': 'error'
    },
    env: {
        browser: true,
    }
}
