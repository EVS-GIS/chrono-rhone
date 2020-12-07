<template>
  <div class="columns">
    <sidebar v-show="open"/>
    <div class="column">
      <fullmap/>
    </div>
  </div>
</template>

<script>
import Sidebar from './../layouts/sidebar/Sidebar'
import Fullmap from './../layouts/content/map/Map'
import { mapState } from "vuex"
export default {
  name: "Home",
  components: {
    Sidebar,
    Fullmap
  },
  computed: {
    ...mapState({
      screen: state => state.screen,
      open: state => state.filters.open
    })
  },
  created(){
    this.$store.dispatch('getEvents')
  }
}
</script>

<style scoped>
.column{
  padding: 5px 0 0 10px;
}
</style>

