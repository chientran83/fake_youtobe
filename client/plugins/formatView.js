import Vue from "vue";

const result = Vue.filter('formatView',function(value){
    const length = value.toString().length;
    if(length > 3 && length < 7){
      return value.toString().slice(0,-3)+'K';
    }else if(length > 6 && length < 10){
      return value.toString().slice(0,-6)+'M';
    }else if(length > 9){
      return value.toString().slice(0,-9)+'B';
    }else{
      return value;
    }
})

export default result;