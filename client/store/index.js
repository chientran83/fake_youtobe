import Vuex from 'vuex'
const store = () => {
 return new Vuex.Store({
    state: () => ({
      visibleModalUpload:false,
      userLogin:false
    }),
    mutations: {
      changeVisibleModalUpload(state){
          state.visibleModalUpload = !state.visibleModalUpload
      }
    },
    actions:{

    },
    getters:{
      
    }
  })
}

export default store;
    