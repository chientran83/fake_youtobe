<template>
<article class="w-full h-full my-2 ml-4 flex flex-col xl:flex-row">
   <div class="w-full xl:w-8/12 mb-12">
       <div class="w-full">
           <div class="video-container">
               <video controls>
                    <source :src="$config.baseApiUrl + video.video_path" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
       </div>
       <p class="text-blue-500 mt-3 text-sm"><span>#VietDeep2021</span> <span>#VietChill</span> <span>#VinaHouse</span></p>
       <p class="font-semibold text-xl">{{ video.name }}</p>
       <div class="flex mt-3 justify-between border-solid border-b border-gray-300 pb-4">
           <p><span>{{ video.view | formatMoney }} views</span> . <span>30 Jun 2021</span></p>
           <div class="flex">
               <div class="flex items-center mr-5"><i class="fa-solid fa-thumbs-up mr-3"></i><p>{{ video.like | formatView }}</p> </div>
               <div class="flex items-center mr-5"><i class="fa-solid fa-thumbs-down mr-3"></i><p>DISLIKE</p></div>
               <div class="flex items-center mr-5"><i class="fa-solid fa-share mr-3"></i><p>SHARE</p></div>
           </div>
       </div>
       <div class="w-full mt-3 flex items-start">
            <img class="w-12 h-12 rounded-full mr-5" :src="$config.baseApiUrl + video.user.image_path" alt="">
           <div>
               <p class="font-semibold">
                   {{ video.user.name }}
               </p>
               <p class="mb-6 text-sm text-gray-600">
                   {{ video.user.subscriber }} subscribers
               </p>
               <p>
                   {{ video.description }}
               </p>
           </div>
            <p class="px-3 py-2 bg-red-600 ml-auto">SUBSCRIBE</p>
           
       </div>
   </div>
   <div class="w-full xl:w-4/12 xl:pl-6">
        <nuxt-link v-for="(index,key) in videos" v-bind:key="key" :to="'/videos/' + index.id" tag="div" class="w-full flex mb-3 cursor-pointer">
                <img class="w-44 h-24 mr-2 " :src="$config.baseApiUrl + index.image_path" alt="">
                <div>
                    <p class="font-semibold">{{index.name}}</p>
                    <p class="text-gray-500">{{index.user.name}}</p>
                    <p class="text-gray-500">{{index.view | formatView}} views</p>
                </div>
        </nuxt-link>
   </div>
</article>
</template>
<script>
import axios from "axios"
export default {
    name:"videoIdIndex",
    async asyncData({ params }){
        const getVideo = await axios.get('http://localhost:8000/api/v1/video/'+ params.id)
        return {video:getVideo.data.data}
    },
    data(){
        return {
            videos:[]
        }
    },
    created() {
        const videoList = this.$store.state.videos;
        this.videos = videoList.filter((item) => {return item.id !== parseInt(this.$route.params.id, 10)})
    },
}
</script>
<style scoped>
.video-container {
    overflow: hidden;
    position: relative;
    width:100%;
}

.video-container::after {
    padding-top: 56.25%;
    display: block;
    content: '';
}

.video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>