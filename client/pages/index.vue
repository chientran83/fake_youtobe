<template>
  <article class="w-full h-full border-t border-gray-300 border-solid mt-2 ml-4">
    <div class="tag w-full">
      <ul class="flex my-2 mx-5">
        <li class="bg-black text-white py-1 px-3 text-sm rounded-full">All</li>
        <li class="py-1 px-3 text-sm rounded-full border-gray-300 border-solid border ml-2 bg-gray-100">Ukraine</li>
        <li class="py-1 px-3 text-sm rounded-full border-gray-300 border-solid border ml-2 bg-gray-100">Viet Nam</li>
        <li class="py-1 px-3 text-sm rounded-full border-gray-300 border-solid border ml-2 bg-gray-100">U23 Viet Nam</li>
        <li class="py-1 px-3 text-sm rounded-full border-gray-300 border-solid border ml-2 bg-gray-100">Thời sự</li>
        <li class="py-1 px-3 text-sm rounded-full border-gray-300 border-solid border ml-2 bg-gray-100">Báo thanh niên</li>
      </ul>
    </div>
    <div class="video bg-gray-50 border-t border-gray-300 border-solid h-auto p-5 grid grid-cols-1 md:grid-cols-2  lg:grid-cols-3 gap-6 xl:grid-cols-4 ">
        <NuxtLink v-for="(index,key) in videos" :key="key" :to="'/videos/' + index.id" tag="div" class="cursor-pointer h-auto" >
          <img class="w-full h-40 bg-no-repeat bg-center bg-cover mb-3" :src="$config.baseApiUrl+index.image_path" alt="">
          <div class="intro flex">
            <img class="w-10 h-10 bg-no-repeat bg-center bg-cover rounded-full mr-3" :src="$config.baseApiUrl+index.user.image_path" alt="">
            <div class="desc">
              <div class="title font-semibold mb-1">
                {{ index.name }}
              </div>
              <div class="author_name text-gray-600 flex">
                <p class="mr-2">{{ index.user.name }}</p> <span><i class="fas fa-check-circle"></i></span>
              </div>
              <div class="view"> {{ index.view | formatView }} <span>views</span>
              </div>
            </div>

          </div>
        </NuxtLink>
        
      
    </div>
  </article>
</template>
<script>
export default {
  name: 'IndexPage',
  data() {
    return {
      videos: []
    }
  },
  created() {
    this.videos = this.$store.getters.getVideos;
  }
}
</script>
