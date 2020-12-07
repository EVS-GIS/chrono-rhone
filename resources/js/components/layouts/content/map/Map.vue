<template>
  <div class="map-container">
    <b-loading is-full-page v-model="loading" :can-cancel="true"></b-loading>
    <div id="map">
    </div>
    <b-modal :active.sync="ismodalEventActive" :can-cancel="false">
      <single-event v-bind="modalEvent"></single-event>
    </b-modal>
  </div>
</template>

<script>
import * as mapboxgl from 'mapbox-gl'
import * as turf from '@turf/helpers'
import { mapState } from 'vuex'
import MapPopup from './MapPopup'
import singleEvent from './../event/single'
import selectEvent from './../map/selectEvent'
export default {
  name: 'Map',
  components: {
    singleEvent,
    MapPopup
  },
  data() {
    return {
      map: null,
      mapReady: false,
      modalEvent: null,
      ismodalEventActive: false,  
    }
  },
  computed: {
    ...mapState({
      km: state => state.filters.km,
      thematics: state => state.filters.thematics,
      relationships: state => state.filters.relationships,
      maplayers: state => state.filters.maplayers,
      events: state => state.data.events,
      open: state => state.filters.open
    }),
    activeThemes(){
      return this.thematics.map(thematic => thematic.themes.filter(theme => theme.active === true).map(theme => theme['name_'+this.lang])).flat()
    },
    activeRelationships(){
      return this.relationships.filter(relation => relation.active === true).map(relation => relation.id)
    },
    activeMaplayers(){
      return this.maplayers.filter(layer => layer.active === true).map(layer => layer.id)
    },
    colors(){
      return this.thematics.map(thematic => thematic.themes.filter(theme => theme.active === true).map(theme => {
        return {
          theme: theme.name,
          color: theme.color
        }
      })).flat()
    },
    dataReady(){
      if(this.events && this.thematics && this.relationships){
        return true
      }
      return false
    },
    loading(){
      return !this.dataReady
    },
    lang(){
      return this.$i18n.locale
    }
  },
  async mounted() {
    await this.loadMap()
    this.mapReady = true
  },
  watch: {
    'events': {
      handler: function() {
        if(this.dataReady && this.mapReady) {
          this.calculateSources()
        }
      },
      deep:true
    },
    'thematics': {
      handler: function() {
         if(this.dataReady && this.mapReady) {
          this.calculateSources()
        }
      },
      deep:true
    },
    'km': {
      handler: function() {
         if(this.dataReady && this.mapReady) {
          this.calculateSources()
        }
      },
      deep:true
    },
    'relationships': {
      handler: function() {
         if(this.dataReady && this.mapReady) {
          this.calculateSources()
        }
      },
      deep:true
    },
    activeMaplayers() {
      this.visibleMaplayers()
    },
    lang(){
      if(this.dataReady && this.mapReady) {
        this.calculateSeries()
      }
    },
    open(){
      this.map.resize()
    }
  },
  methods: {
    async loadMap() {
      return new Promise(resolve => {
        mapboxgl.accessToken = process.env.MIX_MAPBOX_KEY
        if (!mapboxgl.supported()) {
          alert('Your browser does not support Mapbox GL')
        } else {
          this.map = new mapboxgl.Map({
            container: 'map',
            style: process.env.MIX_MAPBOX_STYLE,
            center: [6.35, 44.56],
            zoom: 7,
          })
          this.map.addControl(new mapboxgl.NavigationControl(), 'top-left')
          this.addSources()
          this.addLayers()
          this.setMapEvents()
          resolve()
        }
      })
    },
    addSources() {
      this.map.on('style.load', () => {
        this.map.addSource('pointSource', {
          type: 'geojson',
          data:  null
        })
        this.map.addSource('lineSource', {
          type: 'geojson',
          data: null
        })
        this.map.addSource('polygonSource', {
          type: 'geojson',
          data: null
        })
        this.map.addSource('satellite', {
          'type': 'raster',
          "url": "mapbox://mapbox.satellite",
          'tileSize': 256,
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
            'fill-opacity': 0.5
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
            'circle-radius': 8,
            'circle-color': ['get', 'color'],
            'circle-stroke-color': 'white',
            'circle-stroke-width': 1,
            'circle-opacity': 0.5
          }
        })
        this.map.addLayer({
          'id': 'satellite',
          'source': 'satellite',
          'type': 'raster',
          layout: {
            visibility: 'none'
          }
        })
      })
    },
    refreshSource(data, source) {
      this.map.getSource(source).setData(data) 
    },
    calculateSources() {
      let filterEvents = this.events
      if(this.activeRelationships.length !== 0){
        filterEvents = filterEvents.filter(event => this.activeRelationships.filter(id => event.from_events.map(from => from.relationship_id).includes(id)).length > 0
        || this.activeRelationships.filter(id => event.to_events.map(to => to.relationship_id).includes(id)).length > 0) 
      }
      filterEvents = filterEvents.filter(event => this.activeThemes.includes(event.theme['name_'+this.lang])  && (event.km_up >= this.km[0] && event.km_down <= this.km[1]) )
      this.eventsIds(filterEvents)
      const points = filterEvents.filter(event => event.points !== null).map(event => turf.feature(event.points,{id:event.id,title:event["title_"+this.lang],date:this.eventDates(event.start_year,event.start_month,event.start_day,event.end_year,event.end_month,event.end_day),color:event.theme.color}))
      this.refreshSource(turf.featureCollection(points), 'pointSource')
      const lines = filterEvents.filter(event => event.lines !== null).map(event => turf.feature(event.lines,{id:event.id,title:event["title_"+this.lang],date:this.eventDates(event.start_year,event.start_month,event.start_day,event.end_year,event.end_month,event.end_day),color:event.theme.color}))
      this.refreshSource(turf.featureCollection(lines), 'lineSource')
      const polygons = filterEvents.filter(event => event.polygons !== null).map(event => turf.feature(event.polygons,{id:event.id,title:event["title_"+this.lang],date:this.eventDates(event.start_year,event.start_month,event.start_day,event.end_year,event.end_month,event.end_day),color:event.theme.color}))
      this.refreshSource(turf.featureCollection(polygons), 'polygonSource')
    },
    eventsIds(events){
      const ids = events.map(event => event.id)
      this.$store.commit('eventsIds',ids)
    },
    visibleMaplayers() {
      for (let layer of this.maplayers) {
        if (this.activeMaplayers.indexOf(layer.id) > -1) {
          this.map.setLayoutProperty(layer.id, 'visibility', 'visible')
          this.map.moveLayer(layer.id, 'polygonLayer')
        } else {
          this.map.setLayoutProperty(layer.id, 'visibility', 'none')
        }
      }
    },
    popup(){
      let popup = new mapboxgl.Popup({
        closeButton: false,
        closeOnClick: false
      })
      this.map.on('mousemove', e => {
        const features = this.map.queryRenderedFeatures(e.point, {
          layers: ['polygonLayer','lineLayer','pointLayer']
        })
        this.map.getCanvas().style.cursor = features.length ? 'pointer' : ''
        if(features.length >0){
          popup.setLngLat(e.lngLat)
          .setHTML('<div id="vue-popup-content"></div>')
          .addTo(this.map)
          new MapPopup({
            propsData: { features: features },
          }).$mount('#vue-popup-content')
        }else{
          popup.remove()
        }
      })
        
      this.map.on('click', e => {
        const features = this.map.queryRenderedFeatures(e.point, {
          layers: ['polygonLayer','lineLayer','pointLayer']
        })
        if (features.length === 1) {
          this.openEventModal(features[0].properties)
        } else if (features.length > 1){
          this.$buefy.modal.open({
            parent: this,
            hasModalCard: true,
            canCancel:[],
            component: selectEvent,
            props: {
              events: features,
            }
          })
        }
      })
    },
    setMapEvents() {
      this.map.on('load', () => {
        this.popup()
      })
    },
    openEventModal(props){
      this.modalEvent = props
      this.ismodalEventActive = true
    },
    eventDates(start_year,start_month,start_day,end_year,end_month,end_day){
      const start =  new Date(start_year,start_month || 0, start_day || 1)
      const end =  new Date(end_year || start_year,end_month || start_month || 0, end_day || start_day+1 || 2)
      if ( end.getTime() - start.getTime() === 86400000){
        return start.toLocaleDateString()
      } else {
        return  start.toLocaleDateString() + " - " +  end.toLocaleDateString()
      }
    }
  }
}
</script>

<style scoped>
  .map-container{
    margin-top:20px;
    height:92vh;
  }
  #map {
    width: 100%;
    height: 100%;
    position: relative;
  }
</style>