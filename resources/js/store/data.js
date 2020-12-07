const state = {
  events: null,
  eventsIds: []
}

const mutations = {
  getEvents (state, response) {
    state.events = response
  },
  eventsIds (state, response) {
    state.eventsIds = response
  }
}

const actions = {
  async getNbPages ({},url) {
    let response = await axios.get(url)
    let pagesNumber = Number(response.data.meta.last_page)
    return pagesNumber
  },
  async getEvents({commit, dispatch}) {
    try{
      const callPages = []
      const pagesNumber = await dispatch('getNbPages','/events')
      for (let i = 1; i <= pagesNumber; i++) {
        callPages.push(axios.get('/events' + '?page=' + i))
      }
      const responses = await axios.all(callPages)
      const response = responses.map(response =>{
        return response.data.data
      }).flat()
      commit('getEvents', response)
    }
    catch(error) {
      throw error
    }
 }
}

export default {
  state,
  mutations,
  actions
}