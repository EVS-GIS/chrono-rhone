
const state = {
  open: true,
  km: [0,550],
  thematics: null,
  relationships: null,
  maplayers: [
    { id: "satellite", name: "Satellite map", active: false },
  ],
}

const mutations = {
  selectedKm (state, response) {
    state.km = response
  },
  selectedThematics (state, response) {
    state.thematics = response
  },
  selectedRelationships (state, response) {
    state.relationships = response
  },
  selectedMaplayers (state, response) {
    state.maplayers = response
  },
  open (state, response) {
    state.open = response
  }
}

const actions = {
  async getThematics({commit}) {
    try{
      const response = await axios.get('/thematics')
      let thematics = []
      for (let thematic of response.data) {
        thematic.themes.sort((a, b) => a.ranking - b.ranking)
        for (let theme of thematic.themes) {
          theme.active = true
        }
        thematics.push(thematic)
        thematics.sort((a, b) => a.ranking - b.ranking)
      }
    commit('selectedThematics', thematics)
    }
    catch(error) {
      throw error
    }
  },
  async getRelationships({commit}) {
    try{
      const response = await axios.get('/relationships')
      const relationships = response.data.map(relation =>{
        relation.active = false
        return relation
      })
      commit('selectedRelationships', relationships)
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