import Vuex from 'vuex'
import axios from 'axios'
import Cookies from 'js-cookie'

const store = () => {
 return new Vuex.Store({
    state: () => ({
      visibleModalUpload:false,
      userLogin:null,
      videos:null,
      userVideos:null,
      token:null
    }),
    mutations: {
      changeVisibleModalUpload(state){
          state.visibleModalUpload = !state.visibleModalUpload
      },
      setVideos(state,videos){
        state.videos = videos;
      },
      setToken(state,token){
        state.token = token
      },
      setUserLogin(state,user){
        state.userLogin = user
      },
      setUserVideo(state,video){
        state.userVideos = video
      },
      clearToken(state){
        state.token = null;
        state.userLogin = null;
        Cookies.remove('access_token')
        Cookies.remove('expires_in')
        Cookies.remove('user')
        localStorage.removeItem('access_token')
        localStorage.removeItem('expires_in')
        localStorage.removeItem('user')
      }
    },
    actions:{
        nuxtServerInit(vuexContext){
          return axios.get(process.env.baseApiUrl + '/api/v1/video')
            .then(res => {
              vuexContext.commit('setVideos',res.data.data);

            })
        },
        login(vuexContext,credentials) {
          return this.$axios.$post(process.env.baseApiUrl + '/api/v1/user/login',credentials)
            .then(res => {
              vuexContext.commit('setToken',res.access_token);
              vuexContext.commit('setUserLogin',res.user)
              vuexContext.dispatch('setLogoutTime',res.expires_in * 1000)
              localStorage.setItem('access_token',res.access_token);
              localStorage.setItem('expires_in',new Date().getTime() + res.expires_in * 1000);
              localStorage.setItem('user',JSON.stringify(res.user));
              Cookies.set('access_token', res.access_token)
              Cookies.set('expires_in', new Date().getTime() + res.expires_in * 1000)
              Cookies.set('user', JSON.stringify(res.user))
              return {success:true}
            })
            .catch((error)=> {console.log(error)})
        },
        setLogoutTime(vuexContext,duration){
          setTimeout(function(){
            vuexContext.commit('clearToken');
          },duration)
        },
        initAuth(vuexContext,req){
          if(req){
            // get cookie when run in server
            const cookie = req.headers.cookie
            const listCookie = cookie.split(';')
            const token = listCookie.filter((item)=>{
              return item.trim().startsWith('access_token=')
            })
            const tokenValue = token[0].trim().slice(13)
            const expire = listCookie.filter((item)=>{
              return item.trim().startsWith('expires_in=')
            })
            const expireValue = expire[0].trim().slice(11)
            const user = listCookie.filter((item)=>{
              return item.trim().startsWith('user=')
            })
            const userValue = user[0].trim().slice(5);
            if(!tokenValue || new Date().getTime() > expireValue){
              vuexContext.commit('clearToken');
              return false;
            }
            vuexContext.commit('setToken',tokenValue);
            vuexContext.dispatch('setLogoutTime',expireValue - new Date().getTime())
            vuexContext.commit('setUserLogin',JSON.parse(decodeURIComponent(userValue)));
            return true;
          }else{
            // get localStorage when run in client
            const token = localStorage.getItem('access_token');
            const expire = localStorage.getItem('expires_in');
            const user = localStorage.getItem('user');
            if(!token || new Date().getTime() > expire){
              vuexContext.commit('clearToken');
              return false;
            }
            vuexContext.commit('setToken',token);
            vuexContext.commit('setUserLogin',JSON.parse(user));
            vuexContext.dispatch('setLogoutTime',expire - new Date().getTime())
            return true;

          }
        },
        logout(vuexContext){
          return new Promise((resolve) => {
            vuexContext.commit('clearToken')
            resolve ({success:true});
          })
        },
        setUserVideo(vuexContext){
          return this.$axios.$get(process.env.baseApiUrl + '/api/v1/user/video',{headers:{'Authorization': 'Bearer ' + vuexContext.getters.getToken}})
            .then(res => {
              vuexContext.commit('setUserVideo',res.data)
              return {success:true}
            })
        }
    },
    getters:{
      getVideos(state){
        return state.videos
      },
      getUserVideos(state){
        return state.userVideos
      },
      isAuthenticated(state){
        return state.token !== null
      },
      getToken(state){
        return state.token
      }
    }
  })
}
export default store;


    