<template>
  <div v-if="showLoc || showMap">
    <h2 class="subtitle has-text-primary">{{$t('single.location')}}</h2>
    <div v-if="showMap" id="singlemap"></div>
    <div v-if="showLoc" class="is-link">
      <table class="table is-fullwidth has-background-link has-text-white">
        <tbody>
          <tr v-if="geom.km_up != null">
            <td><b>{{$t('single.km_up')}}</b></td>
            <td >{{geom.km_up}}</td>
          </tr>
          <tr v-if="geom.km_down">
            <td><b>{{$t('single.km_down')}}</b></td>
            <td >{{geom.km_down}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import * as turf from '@turf/helpers'
import bbox from '@turf/bbox'
import * as mapboxgl from 'mapbox-gl'
import { mapState } from 'vuex'
export default {
  name: 'singleMap',
  props: ['geom'],
  data () {
    return {
      map: null
    }
  },
  computed:{
    showLoc(){
      if(this.geom.km_up || this.geom.km_down){
        return true
      }
      return false
    },
    showMap(){
      if(this.geom.points || this.geom.lines || this.geom.polygons){
        return true
      }
      return false
    },
  },
  async mounted(){
    if(this.showMap){
      await this.loadMap()
      const geom = turf.featureCollection([turf.feature(this.geom.polygons),turf.feature(this.geom.points),turf.feature(this.geom.lines)])
      this.map.fitBounds(bbox(geom), {
        padding: 60,
        duration: 0,
        maxZoom: 15
      })
    }
  },
  methods:{
    async loadMap() {
      return new Promise(resolve => {
        mapboxgl.accessToken = process.env.MIX_MAPBOX_KEY
        if (!mapboxgl.supported()) {
          alert('Your browser does not support Mapbox GL')
        } else {
          this.map = new mapboxgl.Map({
            container: 'singlemap',
            style: process.env.MIX_MAPBOX_STYLE,
            center: [6.35, 44.56],
            zoom: 12
          })
          this.map.addControl(new mapboxgl.NavigationControl(), 'top-left')
          this.addSources()
          this.addLayers()
          resolve()
        }
      })
    },
    addSources() {
      this.map.on('style.load', () => {
        this.map.addSource('pointSource', {
          type: 'geojson',
          data: turf.featureCollection([turf.feature(this.geom.points,{id:this.geom.id,color:this.geom.theme.color})])
        })
        this.map.addSource('lineSource', {
          type: 'geojson',
          data: turf.featureCollection([turf.feature(this.geom.lines,{id:this.geom.id,color:this.geom.theme.color})])
        })
        this.map.addSource('polygonSource', {
          type: 'geojson',
          data: turf.featureCollection([turf.feature(this.geom.polygons,{id:this.geom.id,color:this.geom.theme.color})])
        })
      })
    },
    addLayers() {
      this.map.on('style.load', () => {
        this.map.addLayer({
          id: 'polygonLayer',
          type: 'fill',
          source: 'polygonSource',
          paint: {
            'fill-color':['get', 'color'],
            'fill-opacity': 0.5, 
          }
        })
        this.map.addLayer({
          id: 'lineLayer',
          type: 'line',
          source: 'lineSource',
          paint: {
            'line-color':['get', 'color'],
            'line-opacity': 0.5,
            'line-width':  5
          }
        })
        this.map.addLayer({
          id: 'pointLayer',
          type: 'circle',
          source: 'pointSource',
          paint: {
            'circle-radius': 10,
            'circle-color': ['get', 'color'],
            'circle-stroke-color': 'white',
            'circle-stroke-width': 1,
            'circle-opacity': 0.5
          }
        })
      })
    },
  }
}
</script>

<style scoped>
  #singlemap {  
    width: 100%;
    height: 350px;
    position: relative; 
  }
  .subtitle {  
    margin-bottom: 0.5rem !important;
  }
</style>