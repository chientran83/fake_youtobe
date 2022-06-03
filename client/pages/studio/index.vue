<template>
  <article class="w-full bg-gray-100 pl-10 h-full border-t border-gray-300 border-solid mt-2 ml-4">
    <p class="text-2xl font-semibold my-6">Channel dashboard</p>
    <div class="grid grid-cols-2 gap-7">
      <div class="border p-2 bg-white">
        <div class="w-full border-2 border-dotted text-center py-20">
          <img class="w-48 h-48 mx-auto" src="	https://www.gstatic.com/youtube/img/creator/no_content_illustration_upload_video_v3.svg" alt="">
          <p class="w-80 mx-auto">Want to see metrics on your recent video? Upload and publish a video to get started.</p>
          <p class="p-3 my-6 bg-blue-500 mx-auto inline-block text-white rounded-sm cursor-pointer hover:bg-blue-600" @click="$store.commit('changeVisibleModalUpload')">UPLOAD VIDEOS</p>
        </div>
      </div>
    </div>
    
  </article>
</template>
<script>
export default {
  name: 'StudioPage',
  layout: 'studio',
  middleware:['auth','checkAuth']
}
</script>
