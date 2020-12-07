<template>
  <div>
    <div id="editmap"></div>
    <b-field>
      <b-collapse :open="false" aria-id="addGeom">
        <b-button slot="trigger" aria-controls="addGeom" type="is-primary" icon-left="code-json">{{$t('fields.geojson')}}</b-button>
        <section>
          <b-input v-model="geojson" type="textarea"></b-input>
          <b-button @click="addGeojsonGeom()" type="is-info">{{$t('common.add')}}</b-button>
        </section>
      </b-collapse>
    </b-field>
  </div>
</template>

<script>
import * as turf from '@turf/helpers'
import bbox from '@turf/bbox'
import combine from '@turf/combine'
import * as mapboxgl from 'mapbox-gl'
import MapboxDraw from '@mapbox/mapbox-gl-draw/dist/mapbox-gl-draw.js'
import { mapState } from 'vuex'
export default {
  name: 'editMap',
  props: ['geom'],
  data () {
    return {
      map: null,
      draw: null,
      geojson: null
    }
  },
  async mounted(){
    await this.loadMap()
    const geom = turf.featureCollection([turf.feature(this.geom.polygons),turf.feature(this.geom.points),turf.feature(this.geom.lines)])
    if(this.geom.polygons || this.geom.points || this.geom.lines){
      this.map.fitBounds(bbox(geom), {
        padding: 60,
        duration: 0
      })
    }
  },
  computed:{
    test(){
      return JSON.parse(this.geojson)
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
            container: 'editmap',
            style: process.env.MIX_MAPBOX_STYLE,
            center: [6.35, 44.56],
            zoom: 5
          })
          this.draw = new MapboxDraw()
          this.map.addControl(new mapboxgl.NavigationControl(), 'top-left')
          this.map.addControl(this.draw, 'top-left')
          this.drawing()
          this.syncGeoms()
          resolve()
        }
      })
    },
    drawing(){
      this.map.on('load', () =>{
        if(this.geom.polygons){
          this.draw.add(turf.feature(this.geom.polygons))
        }
        if(this.geom.lines){
          this.draw.add(turf.feature(this.geom.lines))
        }
        if(this.geom.points){
          this.draw.add(turf.feature(this.geom.points))
        }     
      })  
    },
    addGeojsonGeom(){
      if(this.geojson){
        const geojson = JSON.parse(this.geojson)
        if(geojson.features){
          const point = combine(turf.featureCollection(geojson.features.filter(feature => feature.geometry.type === 'MultiPoint' || feature.geometry.type === 'Point' )))
          if (point.features.length > 0){
            this.draw.add(point.features[0].geometry)
          }
          const polygon = combine(turf.featureCollection(geojson.features.filter(feature => feature.geometry.type === 'MultiPolygon' || feature.geometry.type === 'Polygon' )))
          if (polygon.features.length > 0){
            this.draw.add(polygon.features[0].geometry)
          }
          const line = combine(turf.featureCollection(geojson.features.filter(feature => feature.geometry.type === 'MultiLineString' || feature.geometry.type === 'LineString' )))
          if (line.features.length > 0){
            this.draw.add(line.features[0].geometry)
          }
        }
        this.combineGeoms()
      }
    },
    calculateGeom(data,type){
      const geom = combine(turf.featureCollection(data.features.filter(feature => feature.geometry.type === 'Multi'+type || feature.geometry.type === type )))
      if (geom.features.length > 0){
        return geom.features[0].geometry
      }
      return null
    },
    combineGeoms(){
      const data = this.draw.getAll()
      this.geom.polygons = this.calculateGeom(data,'Polygon')
      this.geom.lines = this.calculateGeom(data,'LineString')
      this.geom.points = this.calculateGeom(data,'Point')
    },
    syncGeoms(){
      this.map.on('draw.create',(e) =>{
        this.combineGeoms()
      }).on('draw.update',(e) =>{
        this.combineGeoms()
      }).on('draw.delete',(e) =>{
        this.combineGeoms()
      })
    }
  }
}
</script>

<style scoped lang="scss">
  @import '~@mapbox/mapbox-gl-draw/dist/mapbox-gl-draw.css';
  #editmap {  
    width: 100%;
    height: 350px;
    position: relative; 
  }
</style>