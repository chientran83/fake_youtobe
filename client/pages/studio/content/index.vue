<template>
   <article class="w-full bg-gray-100 pl-10 border-t border-gray-300 border-solid mt-2 ml-4" style="min-height: 1000px;">
    <p class="text-2xl font-semibold my-6">Channel content</p>
    <div class="bg-white">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          Video
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Name 
                      </th>
                      <!-- <th scope="col" class="px-6 py-3">
                          Visibility 
                      </th> -->
                      <th scope="col" class="px-6 py-3">
                          Date
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Views
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Experiment thumbnail
                      </th>
                     <!--  <th scope="col" class="px-6 py-3">
                          Like
                      </th> -->
                      <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
                  </tr>
              </thead>
              <tbody>
                   <tr v-for="(item,key) in videos" :key="key" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <th scope="row" class="pl-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                          <img class="w-40" :src="$config.baseApiUrl + item.displayThumbnail.image_path" alt="">
                      </th>
                      <td class="px-6 py-4">
                          {{ item.name }}
                      </td>
                      <!-- <td class="px-6 py-4">
                          True
                      </td> -->
                      <td class="px-6 py-4">
                          {{ item.created_at }}
                      </td>
                      <td class="px-6 py-4">
                          {{ item.view | formatView }}
                      </td>
                      <td class="px-6 py-4">
                          <!-- <i class="far fa-eye cursor-pointer" @click="changeVisibleModalExperiment"></i> -->
                          <div>
                              <div class="flex mb-1">
                                  <img class="w-40 mr-1" :src="$config.baseApiUrl + item.popular_thumbnail.image_path" alt="">
                                  <p class="mr-1"> view:{{  item.popular_thumbnail.view }} </p>
                                  <p> percent:{{ item.thumbnail | percentOfThumbnail(item.popular_thumbnail.view) }}%</p>
                              </div>
                          </div>
                      </td>
                      <td class="px-6 py-4 text-right">
                          <div class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer" @click="deleteVideo(item.id)">Delete</div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
    </div>
  </article>
</template>
<script>
import axios from "axios"
export default {
  name: 'StudioContent',
    filters: {
      percentOfThumbnail(value,number){
        let total = 0;
        value.forEach((value) => {
            total += value.view;
        });
        const percent = number / total * 100;
        return percent.toFixed(2);
      }
  },
  layout:'studio',
  middleware:['checkAuth','auth'],
  data(){
      return {
          videos:null,
          visibleModalExperiment:null,
      }
  },
  created(){
      this.$store.dispatch('setUserVideo')
        .then(() => {
            this.videos = this.$store.getters.getUserVideos
        })
  },
  methods: {
      deleteVideo(id){
          axios.delete(process.env.baseApiUrl + '/api/v1/video/' + id,{headers:{Authorization : 'Bearer ' + this.$store.getters.getToken}})
            .then(res => {
                if(res.data.code === 200){
                    alert('delete success !')
                    this.videos = this.videos.filter(item => {return item.id !== id})
                }else{
                    alert('error !')
                }
            })
            .catch((error) => {
                console.error(error)
            })
      },
      changeVisibleModalExperiment(){
          this.visibleModalExperiment = !this.visibleModalExperiment;
      }
  }
}
</script>
