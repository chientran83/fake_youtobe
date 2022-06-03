<template>
    <div class="box border border-solid border border-gray-300 rounded-md mx-auto my-24 shadow-xl">
        <nuxt-link to="/">
            <img class="w-20 mx-auto mt-12 mb-5" src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_of_YouTube_%282015-2017%29.svg" alt="">
        </nuxt-link>
        <div class="w-full text-center">
            <p class="font-semibold text-xl">Sign in</p>
        </div>
        <div class="w-96 mx-auto mb-5">
            <p class="mb-3">Email</p>
            <input  v-model="user.email" type="text" class="w-full border border-solid border-gray-500 p-3"  placeholder="Enter email!">
        </div>
        <div class="w-96 mx-auto">
            <p class="mb-3">Password</p>
            <input v-model="user.password" type="password" class="w-full border border-solid border-gray-500 p-3"  placeholder="Enter password!">
        </div>
        <p class="w-96 mx-auto text-blue-600 mt-3 mb-4">Are you forget password ?</p>
        <div class="w-96 mx-auto flex justify-between items-center mb-20">
            <nuxt-link to="/register" tag="p" class="text-blue-600 cursor-pointer" >
                Sign up
            </nuxt-link>
            <p class="inline-block py-2 px-4 bg-blue-400 rounded-md text-white cursor-pointer" @click="login">Submit</p>
        </div>
    </div>
</template>
<script>
export default {
    name:'LoginIndex',
    layout:'public',
    data() {
        return {
            user:{
                email:"",
                password:""
            }
        }
    },
    methods:{
        login(){
            this.$store.dispatch('login',this.user)
                .then((success) => {
                    if(success){
                        this.$router.push('/')
                    }
                 })
        }
    }
}
</script>
<style>
    .box{
        width: 30rem;
    }
</style>