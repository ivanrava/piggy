<template>
    <h1>Login</h1>
    <form action="javascript:void(0)" method="post">
        <div v-if="Object.keys(validationErrors).length > 0">
            <ul class="mb-0">
                <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
            </ul>
        </div>

        <input v-model="auth.email" name="email">
        <input v-model="auth.password" name="password">
        <button type="submit" @click="login">
            Login
        </button>
    </form>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            auth: {
                email: '',
                password: ''
            },
            validationErrors: {},
            processing: false
        }
    },
    methods: {
        async login() {
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login', this.auth).then(({data}) => {
                console.log(data)
            }).catch(({response}) => {
                if (response.status === 422) {
                    this.validationErrors = response.data.errors
                } else {
                    this.validationErrors = {}
                    alert(response.data.message)
                }
            }).finally(() => {
                this.processing = false
            })
        }
    }
}
</script>

<style scoped>

</style>
