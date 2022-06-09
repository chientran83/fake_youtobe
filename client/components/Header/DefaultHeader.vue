<template>
    <div class="w-full flex items-center justify-between">
        <div class="flex items-end w-52">
            <div class="text-xl px-5 py-2">
                <i class="fa-solid fa-align-left"></i>
            </div>
            <div class="flex py-2 cursor-pointer" @click="redirectStudioPage">
                <div class="w-9 h-6 rounded-md bg-red-500 text-xs text-white flex justify-center items-center">
                    <i class="fa-solid fa-play"></i>
                </div>
                <div class="title text-xl font-bold ml-1 tracking-tighter">
                    <p>YouToBe</p>
                </div>
                <div class="text-xs ml-1">
                    <p>vn</p>
                </div>
            </div>
        </div>
        <div class="flex w-full justify-center"> 
            <input class="w-full max-w-xl outline-none border-gray border-solid border-2 px-2 py-1" type="text" placeholder="Search">
            <div class="bg-gray-200 w-14 height-full flex justify-center items-center ">
               <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="mx-2 w-10 flex rounded-full justify-center items-center pd bg-gray-100">
                <i class="fa-solid fa-microphone"></i>
            </div>
        </div>
        
        <div class="py-2 flex text-2xl w-96 justify-between">
            <nuxt-link to="/studio" class="create text-gray-300 cursor-pointer">
              <i class="fa-solid fa-circle-plus"></i>
            </nuxt-link>
            <div class="notice text-gray-300">
                <i class="fa-solid fa-bell"></i>
            </div>
            <client-only>

                <div v-if="$store.state.userLogin">
                    <div class="avatar h-full w-10 mr-9 bg-center bg-cover bg-no-repeat relative">
                        <img class="h-full w-full rounded-full cursor-pointer " :src="$config.baseApiUrl + $store.state.userLogin.image_path" alt="" @click="visiblePopup = !visiblePopup" >
                        
                        <div v-if="visiblePopup" class="w-72 h-96 absolute right-12 top-0 border border-solid border-gray-300 bg-white z-10">
                            <div class="w-full h-100 p-3 flex">
                                <img class="h-10 w-10 rounded-full mr-2" :src="$config.baseApiUrl + $store.state.userLogin.image_path" alt="">
                                <div class="flex flex-col">
                                    <p class="text-lg text-black font-semibold">{{$store.state.userLogin.name}}</p>
                                    <p class="text-sm text-blue-500">Manage your Google Account</p>
                                </div>
                            </div>
                            <div class="w-full h-100 p-3 flex border-solid border-t border-b border-gray-300">
                                <ul class="w-full h-auto">
                                    <li class="flex w-full text-base hover:bg-gray-200 py-3 px-4 items-center cursor-pointer">
                                        <i class="fas fa-video w-1/4"></i>
                                        <nuxt-link to="/studio" class="w-3/4 ">
                                        Manage your videos
                                        </nuxt-link>
                                    </li>
                                </ul>
                            </div>
                            <div class="w-full h-100 p-3 flex">
                                <ul class="w-full h-auto">
                                    <li class="flex w-full text-base hover:bg-gray-200 py-3 px-4 items-center cursor-pointer" @click="logout">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-1/4 center"></i>
                                        <p class="w-3/4 ">Sign out</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="flex text-blue-600 items-center text-xs lg:text-base border border-solid border-blue-600 py-1 px-2 md:px-3 mr-2 cursor-pointer" @click="$router.push('/login')">
                        <i class="far fa-user mr-2"></i>
                        <p class="">SIGN IN</p>
                    </div>
                </div>
            </client-only>  
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            visiblePopup: false
        }
    },
    created(){
        if(process.client){
            this.$store.dispatch('initAuth')
        }
    },
    methods: {
        redirectStudioPage(){
            this.$router.push('/')
        },
        logout(){
            this.$store.dispatch('logout')
                .then((e) => {
                        this.$router.push('/login')
                    })
        }
    }
}
</script>
<style scoped>
    .title {
        font-family: 'Roboto Condensed', sans-serif;
    }
</style>