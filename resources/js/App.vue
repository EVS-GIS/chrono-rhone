<template>
  <div id="app" >
    <Navbar></Navbar>
    <section class="section">
      <router-view/>
    </section>
  </div>
</template>

<script>
import Navbar from './components/layouts/header/Navbar'

export default {
  name: 'App',
  components: {
    Navbar
  },
  data() {
    return {
      window: {
        width: window.innerWidth,
        height: window.innerHeight
      },
      device: 'desktop'
    }
  },
  mounted() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  destroyed() {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
      handleResize() {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.$store.commit('setWindow',this.window)
      if( this.window.width <= 768 ) {
        this.device = 'mobile'
      } else if(this.window.width > 768 && this.window.width < 1215){
        this.device = 'tablet'
      }else{
        this.device = 'desktop'
      }
      this.$store.commit('setDevice',this.device)
    }
  }
}
</script>
<style lang="scss">
  @import "~bulmaswatch/lumen/variables";
  @import "~bulma/sass/utilities/_all";
  @import "~@mdi/font/css/materialdesignicons.min.css";
  @import "~mapbox-gl/dist/mapbox-gl.css";
  $modal-content-width: 960px;
  $colors: (
    "white": ($white, $black),
    "black": ($black, $white),
    "light": ($light, $light-invert),
    "dark": ($dark, $dark-invert),
    "yellow":($yellow,$yellow-invert),
    "primary": ($primary, $primary-invert),
    "info": ($info, $info-invert),
    "success": ($success, $success-invert),
    "warning": ($warning, $warning-invert),
    "danger": ($danger, $danger-invert),
    "link": ($link,$link-invert)
  );
  @import "~bulma";
  @import "~bulmaswatch/lumen/overrides";
  @import "~buefy/src/scss/buefy";
  .container{
    margin-top:70px;
  }
  .modal-card-foot{
    justify-content: flex-end;
  }
  .separator {
    background-color: $primary;
  }
  .b-checkbox.checkbox input[type="checkbox"]:checked + .check.is-info,
  .b-checkbox.checkbox input[type="checkbox"] + .check{
    position: absolute;
    z-index: 10;
    left:0px;
    top:-5px;
  }
  .b-checkbox.checkbox input[type="checkbox"] + .check{
    background: #fff;
  }
</style>
<style scoped>
 .section{
   padding: 0.5rem 1rem 0;
 }
</style>