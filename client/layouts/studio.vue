<template>
<div class="box-sizing relative w-full h-full">
  <StudioHeader></StudioHeader>
  <section class="flex w-full h-full items-start" >
    <StudioNavigation></StudioNavigation>
    <nuxt />
  </section>
  <!-- modal upload image-->
    <div v-if="$store.state.visibleModalUpload" class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 p-10" >
      <div class="w-full md:w-4/5 lg:w-3/5 bg-white mx-auto my-auto rounded-md">
        <div>
          <div class="flex justify-between border-b border-solid border-gray-200">
            <p class="text-xl font-semibold m-3">Upload videos</p>
            <i class="fas fa-times m-3 p-2 text-md cursor-pointer text-gray-600 hover:text-black" @click="$store.commit('changeVisibleModalUpload')"></i>
          </div>
          <div v-if="circleLoading" class="text-center mt-6 pb-10">
             <div class="w-24 h-24 p-5 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                  <div class="w-24 h-2 bg-white animate-spin rounded-lg"></div>
              </div>
            <h1>Loading...</h1>
          </div>
          <div v-else class="text-center mt-6 pb-10">
            <img class="w-40 mx-auto" src="/images/imageUpload.png" @click="$refs.uploadFile.click()">
            <div v-if="hasFile">
              <p>File name : {{ fileInfo.name }} <i class="fa-solid fa-xmark ml-5 text-red-500 cursor-pointer" @click="deleteFile"></i></p>
              <p>File type : {{ fileInfo.type }}</p>
              <p>File size : {{ fileInfo.size }}</p>
              <div class="my-2">
                <span>Name : </span>
                <input v-model="video.name" type="text" placeholder="Enter name">
                <span class="text-red-500">{{ messages.nameMissing }}</span>
              </div>
              <div class="my-2">
                <span>Description : </span>
                <input v-model="video.description"  type="text" placeholder="Enter description">
                <span class="text-red-500">{{ messages.descriptionMissing }}</span>
              </div>
              <div class="my-2">
                <span>Thumbnails : </span>
                <select v-model="visibleUploadMultipleImage" @change=" visibleUploadMultipleImage === 'true' ? visibleUploadMultipleImage = true : visibleUploadMultipleImage = false ">
                  <option value="false">An image</option>
                  <option value="true">Lost of pictures</option>
                </select>
              </div>
              <div v-if="visibleUploadMultipleImage">
                <input ref="inputImage" type="file" multiple @change="previewImage">
                <div class="my-2 mx-auto w-96 flex justify-center">
                  <div class="flex" v-html="imagePreviewBeforeUpload" ></div>
                  <i v-if="$refs.uploadFile.files[0]" class="fa-solid fa-xmark ml-3 text-red-500 cursor-pointer inline" @click="deleteImagePreviewBeforeUpload"></i>
                </div>
              </div>
              <div v-else>
                <input ref="inputImage" type="file" @change="previewImage">
                <div class="my-2 mx-auto w-96 flex justify-center">
                  <div v-html="imagePreviewBeforeUpload"></div>
                  <i v-if="$refs.uploadFile.files[0]" class="fa-solid fa-xmark ml-3 text-red-500 cursor-pointer inline" @click="deleteImagePreviewBeforeUpload"></i>
                </div>
              </div>
            </div>
            <div v-else>
              <p class="font-normal">Drag and drop video files to upload</p>
              <p class="text-gray-600 text-sm">Your videos will be private until you publish them.</p>
              <p class="text-white p-3 inline-block bg-blue-500 font-semibold mt-5 mb-40 cursor-pointer " @click="$refs.uploadFile.click()">SELECT FILES</p>
            </div>
            <p v-if="hasFile" class="text-white p-3 inline-block bg-blue-500 font-semibold mt-5 mb-20 cursor-pointer " @click="uploadFile">UPLOAD</p>
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
import axios from "axios"
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
      },
      video:{
        name:"",
        description:""
      },
      imagePreviewBeforeUpload: '<img id="blah" class="w-60 mr-1" src="/images/default.jpg" alt="your image" />',
      messages:{
        nameMissing:"",
        descriptionMissing:"",
      },
      circleLoading:false,
      visibleUploadMultipleImage:false
    }
  },
  methods: {
    uploadFile(){
      if(!this.video.name || !this.video.description){
        if(!this.video.name){
          this.messages.nameMissing = "Please enter this information !"
        }else{
          this.messages.nameMissing = ""
        }
        if(!this.video.description){
          this.messages.descriptionMissing = "Please enter this information !"
        }else{
          this.messages.descriptionMissing = ""
        }
      }else{
        this.circleLoading = true;
        const formData = new FormData();
        formData.append('name',this.video.name)
        formData.append('description',this.video.description)
        for(let i = 0; i < this.$refs.inputImage.files.length; i++){
          formData.append('image[]',this.$refs.inputImage.files[i])
        }
        for (const [key, value] of formData) {
          console.log(`${key}: ${value}`)
        }
        formData.append('video',this.$refs.uploadFile.files[0])
        axios.post(process.env.baseApiUrl + '/api/v1/video',formData,{headers: {
          'Authorization' : 'Bearer ' + this.$store.getters.getToken,
          'Content-Type' : 'multipart/form-data',
          }}).then(res => {
            if(res.data.code === 200){
              alert('add success !')
              this.hasFile = false;
              this.fileInfo.name = "";
              this.fileInfo.type = "";
              this.fileInfo.size = "";
              this.messages.nameMissing = ""
              this.messages.descriptionMissing = ""
              this.video.name = ""
              this.video.description = ""
              this.circleLoading = false
              this.imagePreviewBeforeUpload = '<img id="blah" class="w-60 mr-1" src="/images/default.jpg" alt="your image" />'
            }else{
              alert('error !')
              this.hasFile = false;
              this.fileInfo.name = "";
              this.fileInfo.type = "";
              this.fileInfo.size = "";
              this.messages.nameMissing = ""
              this.messages.descriptionMissing = ""
              this.video.name = ""
              this.video.description = ""
              this.circleLoading = false
              this.imagePreviewBeforeUpload = '<img id="blah" class="w-60 mr-1" src="/images/default.jpg" alt="your image" />'
            }
          })
          .catch(error => {
            console.log(error)
            this.circleLoading = false
          })
        
      }
    },
    existingFile(){
      if(this.$refs.uploadFile.files[0]){
        this.hasFile = true;
        this.fileInfo.name = this.$refs.uploadFile.files[0].name;
        this.fileInfo.type = this.$refs.uploadFile.files[0].type;
        this.fileInfo.size = this.$refs.uploadFile.files[0].size;
      }
    },
    deleteFile(){
      this.$refs.uploadFile.value = null;
      this.$refs.inputImage.value = null;
      this.hasFile = false;
      this.fileInfo.name = "";
      this.fileInfo.type = "";
      this.fileInfo.size = "";
      this.imagePreviewBeforeUpload = '<img id="blah" class="w-60 mr-1" src="/images/default.jpg" alt="your image" />'
      this.messages.nameMissing = ""
      this.messages.descriptionMissing = ""
    },
    previewImage(){
      if(this.$refs.inputImage.files.length > 1){
        for(let i=0; i < this.$refs.inputImage.files.length;i++){
          if(i === 0){
            this.imagePreviewBeforeUpload = '<img id="blah" class="w-24 mr-1" src="' + URL.createObjectURL(this.$refs.inputImage.files[i]) +'" alt="your image" />'
          }else{
            this.imagePreviewBeforeUpload = this.imagePreviewBeforeUpload + '<img id="blah" class="w-24 mr-1" src="' + URL.createObjectURL(this.$refs.inputImage.files[i]) +'" alt="your image" />'
          }
        }
      }else{
        const [file] = this.$refs.inputImage.files
        if (file) {
          this.imagePreviewBeforeUpload = '<img id="blah" class="w-60 mr-1" src="' + URL.createObjectURL(file) +'" alt="your image" />'
        }

      }
    },
    deleteImagePreviewBeforeUpload(){
      this.imagePreviewBeforeUpload = '<img id="blah" class="w-60 mr-1" src="/images/default.jpg" alt="your image" />'
      this.$refs.inputImage.value = null;
    },
  }
}
</script>