import jwt_decode from 'jwt-decode'

// On définit les types de mutations possibles
const AUTH_REQUEST = 'AUTH_REQUEST'
const AUTH_ERROR = 'AUTH_ERROR'
const AUTH_SUCCESS = 'AUTH_SUCCESS'
const AUTH_LOGOUT = 'AUTH_LOGOUT'

// On définit les états possibles
const state = {
  token: localStorage.getItem('token') || '',
  status: '', 
  hasLoadedOnce: false
}

const getters = {
  isAuthenticated: state => {
    if(!!state.token && jwt_decode(state.token).exp *1000 >= new Date()){
      return true
    }
    return false
  },
  authStatus: state => state.status,
  isAdmin: (state,getters) => {
    if(getters.isAuthenticated && jwt_decode(state.token).role === "admin"){
      return true
    }
    return false
  },
  isEditor: (state,getters) => {
    if(getters.isAuthenticated && jwt_decode(state.token).role === "editor"){
      return true
    }
    return false
  },
  isContributor: (state,getters) => {
    if(getters.isAuthenticated && jwt_decode(state.token).role === "contributor"){
      return true
    }
    return false
  },
  user: state => {
    if(!!state.token){
      const user = {
        id:jwt_decode(state.token).id,
        firstname:jwt_decode(state.token).firstname,
        name:jwt_decode(state.token).name
      }
      return user
    }
  }

}

// On définit nos mutations
const mutations = {
  [AUTH_REQUEST]: (state) => {
    state.status = 'loading'
  },
  [AUTH_SUCCESS]: (state, resp) => {
    state.status = 'success'
    state.token = resp.data.access_token
    state.hasLoadedOnce = true
  },
  [AUTH_ERROR]: (state) => {
    state.status = 'error'
    state.hasLoadedOnce = true
  },
  [AUTH_LOGOUT]: (state) => {
    state.status = ''
    state.token = ''
  }
}

const actions = {
  [AUTH_REQUEST]: ({commit, dispatch}, credentials) => {
    return new Promise((resolve, reject) => {
      commit(AUTH_REQUEST)
      axios.post('auth/login', credentials)
      .then(resp => {
        localStorage.setItem('token', resp.data.access_token)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + resp.data.access_token
        commit(AUTH_SUCCESS, resp)
        dispatch('getUserData')
        resolve(resp)
      })
      .catch(err => {
        commit(AUTH_ERROR, err)
        localStorage.removeItem('token')
        reject(err)
      })
    })
  },
  [AUTH_LOGOUT]: ({commit, dispatch}) => {
    return new Promise((resolve, reject) => {
      commit(AUTH_LOGOUT)
      localStorage.removeItem('token')
      resolve()
    })
  }
}

export default {
  state,
  getters,
  mutations,
  actions
}
