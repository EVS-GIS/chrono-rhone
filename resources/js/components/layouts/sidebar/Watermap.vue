<template>
  <div class="map-container">
    <div id="watermap"></div>
  </div>
</template>

<script>
import rhone from './../../../assets/rhone.json'
import {isEqual} from "lodash"
import { mapState } from "vuex"
import * as mapboxgl from 'mapbox-gl'
import lineSliceAlong from '@turf/line-slice-along'
import * as turf from '@turf/helpers'

export default {
  name: "Watermap",
  data() {
    return {
      map: null,
    }
  },
  computed: {
    ...mapState(['filters'])
  },
  watch: {
    'filters.km': {
      handler: function(val,oldVal) {
        if(!isEqual(val, oldVal)) {
        this.refreshSource(this.slice(),'rhoneSource')
        }
      },
      deep:true
    }
  },
  methods:{
    loadMap() {
      mapboxgl.accessToken = process.env.MIX_MAPBOX_KEY
      if (!mapboxgl.supported()) {
        alert('Your browser does not support Mapbox GL')
      } else {
        this.map = new mapboxgl.Map({
          container: 'watermap',
          style: process.env.MIX_MAPBOX_STYLE,
          center: [6.35, 44.56],
          zoom: 4
        })
        //this.map.addControl(new mapboxgl.NavigationControl(), 'top-left')
        this.addSources()
        this.addLayers()
      }
    },
    addSources() {
      this.map.on('style.load', () => {
        this.map.addSource('rhoneSource', {
          type: 'geojson',
          data: this.slice()
        })
      })
    },
    addLayers() {
      this.map.on('style.load', () => {
        this.map.addLayer({
          id: 'rhoneLayer',
          type: 'line',
          source: 'rhoneSource',
          paint: {
            'line-color': '#158cba',
            'line-width': 3 
          }
        })
      })
    },
    refreshSource(data, source) {
      this.map.getSource(source).setData(data) 
    },
    slice(){
      const slice = lineSliceAlong(rhone.features[0], this.filters.km[0], this.filters.km[1])
      return turf.featureCollection([slice])
    }
  },
  mounted() {
    this.loadMap()
  }
}
</script>

<style scoped>
  #watermap {
    width: 100%;
    height: 150px;
    position: relative;
  }
</style>