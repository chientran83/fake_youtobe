<template>
  <article class="w-full h-full border-t border-gray-300 border-solid mt-2 ml-4">
    <div class="video bg-gray-50 border-t border-gray-300 border-solid h-screen p-5 grid grid-cols-1 md:grid-cols-2  lg:grid-cols-3 gap-6 xl:grid-cols-4 ">
      <NuxtLink v-for="(item,key) in videos" v-bind:key="key" :to="'/videos/' + item.id" tag="div" class="cursor-pointer">
        <img class="w-full h-40 bg-no-repeat bg-center bg-cover mb-3" :src="$config.baseApiUrl + item.image_path" alt="">
        <div class="intro flex">
          <img class="w-10 h-10 bg-no-repeat bg-center bg-cover rounded-full mr-3" :src="$config.baseApiUrl + item.user.image_path" alt="">
          <div class="desc">
            <div class="title font-semibold mb-1">
              Khả năng bảo mật của thẻ căn cước gắn chíp
            </div>
            <div class="author_name text-gray-600 flex">
              <p class="mr-2">{{ item.user.name}}</p> <span><i class="fas fa-check-circle"></i></span>
            </div>
            <div class="view">
              {{ item.view | formatView }} <span>views</span>
            </div>
          </div>

        </div>
      
      </NuxtLink>
    </div>
  </article>
</template>
<script>
export default {
  name: 'userVideos',
  middleware:['checkAuth','auth'],
  data(){
    return {
      videos:null
    }
  },
  created() {
    this.$store.dispatch('setUserVideo')
      .then(() => {
        this.videos = this.$store.getters.getUserVideos;
      })
  },
}
</script>