<template>
  <div class="columns">
    <sidebar v-show="open"/>
    <div class="column">
      <timeline></timeline>
    </div>
  </div>
</template>

<script>
import Sidebar from './../layouts/sidebar/Sidebar'
import Timeline from './../layouts/content/Timeline'
import { mapState } from "vuex"
export default {
  name: "TimelinePage",
  components: {
    Sidebar,
    Timeline
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
  padding: 10px 10px 0;
}
</style>

