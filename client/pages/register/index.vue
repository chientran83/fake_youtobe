<template>
    <div class="box border border-solid border border-gray-300 rounded-md mx-auto mt-20 shadow-xl">
        <nuxt-link to="/">
            <img class="w-20 mx-auto mt-12 mb-5" src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_of_YouTube_%282015-2017%29.svg" alt="">
        </nuxt-link>
        <div class="w-full text-center">
            <p class="font-semibold text-xl">Sign up</p>
        </div>
        <div class="w-96 mx-auto mb-5">
            <p class="mb-3">Email</p>
            <input type="text" class="w-full border border-solid border-gray-500 p-3" placeholder="Enter email!">
        </div>
        <div class="w-96 mx-auto mb-5">
            <p class="mb-3">Password</p>
            <input type="text" class="w-full border border-solid border-gray-500 p-3" placeholder="Enter password!">
        </div>
        <div class="w-96 mx-auto">
            <p class="mb-3">Confirm password</p>
            <input type="text" class="w-full border border-solid border-gray-500 p-3" placeholder="Enter password again!">
        </div>
        <p class="w-96 mx-auto text-blue-600 mt-3 mb-4">Are you forget password ?</p>
        <div class="w-96 mx-auto flex justify-between items-center mb-20">
            <nuxt-link to="/login" tag="p" class="text-blue-600 cursor-pointer">
                 Sign in 
            </nuxt-link>
            <p class="inline-block py-2 px-4 bg-blue-400 rounded-md text-white">Submit</p>
        </div>
    </div>
</template>
<script>
export default {
    name:'RegisterIndex',
    layout:'public'
}
</script>
<style>
    .box{
        width: 30rem;
    }
</style>