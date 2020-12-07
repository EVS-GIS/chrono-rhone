<template>
  <div class='legend is-hidden-mobile has-background-white'>
    <h2> {{$t('map.legend')}}</h2>
    <div class="item" v-for="layer in legend" :key="layer.color">
      <b-icon icon="square" size="is-small" :style="{color:layer.color}"></b-icon>
      <span>{{layer.theme}}</span>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'Legend',
  computed: {
    ...mapState({
      thematics: state => state.filters.thematics
    }),
    lang(){
      return this.$i18n.locale
    },
    legend(){
      if(this.thematics){
        return this.thematics.map(thematic => thematic.themes.filter(theme => theme.active === true).map(theme => {
          return {
            theme: theme['name_'+this.lang],
            color: theme.color
          }
        })).flat()
      }
    },
  }
}
</script>

<style scoped>
  .legend {
    position: fixed;
    bottom: 50px;
    right: 0;
    margin-right: 20px;
    overflow: auto;
    border-radius: 3px;
    padding: 10px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    width: 200px;
    font-size: .8em;
    z-index: 1;
  }
  .legend .icon{
    font-size: 1em;
  }
  h2 {
    font-weight: bold;
    margin-bottom: 10px;
  }
</style>
