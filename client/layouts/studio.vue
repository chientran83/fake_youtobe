<template>
<div class="box-sizing relative">
  <StudioHeader></StudioHeader>
  <section class="flex w-full items-start">
    <StudioNavigation></StudioNavigation>
    <nuxt />
  </section>
  <!-- modal upload image-->
    <div v-if="$store.state.visibleModalUpload" class="absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 p-10" >
      <div class="w-full md:w-4/5 lg:w-3/5 bg-white mx-auto my-auto rounded-md">
        <div>
          <div class="flex justify-between border-b border-solid border-gray-200">
            <p class="text-xl font-semibold m-3">Upload videos</p>
            <i class="fas fa-times m-3 p-2 text-md cursor-pointer text-gray-600 hover:text-black" @click="$store.commit('changeVisibleModalUpload')"></i>
          </div>
          <div class="text-center mt-6 pb-10">
            <img class="w-40 mx-auto" src="http://www.pngall.com/wp-content/uploads/2/Upload-Transparent.png" @click="$refs.uploadFile.click()">
            <div v-if="hasFile">
              <p>File name : {{ fileInfo.name }}</p>
              <p>File type : {{ fileInfo.type }}</p>
              <p>File size : {{ fileInfo.size }}</p>
            </div>
            <div v-else>
              <p class="font-normal">Drag and drop video files to upload</p>
              <p class="text-gray-600 text-sm">Your videos will be private until you publish them.</p>
              <p class="text-white p-3 inline-block bg-blue-500 font-semibold mt-5 mb-40 cursor-pointer " @click="$refs.uploadFile.click()">SELECT FILES</p>
            </div>
            <p v-if="hasFile" class="text-white p-3 inline-block bg-blue-500 font-semibold mt-5 mb-40 cursor-pointer " @click="uploadFile">UPLOAD</p>
            <p class="text-sm">By submitting your videos to YouTube, you acknowledge that you agree to YouTube's Terms of Service and Community Guidelines.</p>
            <p class="text-sm">Please make sure that you do not violate others' copyright or privacy rights. Learn more</p>
            <input ref="uploadFile" type="file" hidden @change="existingFile">
          </div>
        </div>
      </div>
    </div>
</div>
</template>
<script>
import StudioHeader from "../components/Header/StudioHeader.vue"
import StudioNavigation from "../components/Navigation/StudioNavigation.vue"
export default {
  name: 'LayoutStudio',
  components:{StudioHeader,StudioNavigation},
  data(){
    return {
      hasFile: false,
      fileInfo:{
        name:"",
        type:"",
        size:""
      }
    }
  },
  methods: {
    uploadFile(){
      alert('upload thanh cong');
      this.hasFile = false;
      this.fileInfo.name = "";
      this.fileInfo.type = "";
      this.fileInfo.size = "";
    },
    existingFile(){
      this.hasFile = true;
      this.fileInfo.name = this.$refs.uploadFile.files[0].name;
      this.fileInfo.type = "";
      this.fileInfo.size = this.$refs.uploadFile.files[0].size;

    }
  }
}
</script>