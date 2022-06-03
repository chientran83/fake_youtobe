import Vue from "vue"

const result = Vue.filter('formatMoney',function(value){
    return new Intl.NumberFormat('en').format(value)
})
export default result;