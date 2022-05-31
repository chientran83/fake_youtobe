<template>
    <div class="w-auto lg:w-52 h-screen">
        <ul class="w-full">
            <nuxt-link to="/" tag="li" class="flex py-3 cursor-pointer">
                <div class="w-1/3 px-2 lg:px-0 text-center">
                    <i class="fas fa-home-alt"></i>
                </div>
                <p class="w-2/3 hidden lg:block">Home</p>
            </nuxt-link>
          
             <nuxt-link to="/userVideos" tag="li" class="flex py-3 cursor-pointer" >
                <div class="w-1/3 px-2 lg:px-0  text-center">
                   <i class="fas fa-video"></i>
                </div>
                <p class="w-2/3 lg:auto hidden lg:block">Your videos</p>
             </nuxt-link>
        </ul>
    </div>
</template>
<style scoped>
    .nuxt-link-exact-active {
        @apply bg-gray-300 font-semibold
    }
</style>