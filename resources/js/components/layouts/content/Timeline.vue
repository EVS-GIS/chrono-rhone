<template>
  <div id="chart">
    <b-loading is-full-page v-model="loading" :can-cancel="true"></b-loading>
    <apexchart v-if="dataReady" ref="chart" type="rangeBar" height="750" :options="chartOptions" :series="series"></apexchart>
    <div class="columns">
      <div class="column is-2">
        <b-field :label="$t('single.start_year')">
          <b-numberinput v-model="zoom[0]"></b-numberinput>
        </b-field>
      </div>
      <div class="column">
        <b-slider lazy v-model="zoom" :min="steps[0]" :max="new Date().getFullYear()" :step="1">
          <template v-for="val in steps">
            <b-slider-tick :value="val" :key="val">{{ val }}</b-slider-tick>
          </template>
        </b-slider>
      </div>
      <div class="column is-2">
        <b-field :label="$t('single.end_year')">
          <b-numberinput v-model="zoom[1]"></b-numberinput>
        </b-field>
      </div>
    </div>
    <b-modal :active.sync="ismodalEventActive" :can-cancel="false">
      <single-event v-bind="modalEvent"></single-event>
    </b-modal>
  </div>
  
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import { mapState } from 'vuex'
import singleEvent from './event/single'
export default {
  name: "Timeline",
  components: {
    apexchart: VueApexCharts,
    singleEvent
  },
  data() {
    return {
      modalEvent: null,
      ismodalEventActive: false,  
      series: [],
      selection: 'one_year',
      zoom:[],
      steps:[]
    }
  },
  computed: {
    ...mapState({
      km: state => state.filters.km,
      thematics: state => state.filters.thematics,
      relationships: state => state.filters.relationships,
      events: state => state.data.events,
      open: state => state.filters.open,
      screen: state => state.screen
    }),
    lang(){
      return this.$i18n.locale
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
    activeThemes(){
      return this.thematics.map(thematic => thematic.themes.filter(theme => theme.active === true).map(theme => theme['name_'+this.lang])).flat()
    },
    activeRelationships(){
      return this.relationships.filter(relation => relation.active === true).map(relation => relation.id)
    },
    colors(){
      return this.thematics.map(thematic => thematic.themes.filter(theme => theme.active === true).map(theme => theme.color)).flat()
    },
    gap(){
      if (this.screen.device === "mobile"){
        return 100
      }
      return 50
    },
    chartOptions(){
      return {
        /*annotations: {
          xaxis: [
            {
              x: new Date("11/17/1970").getTime(),
              strokeDashArray: 0,
              borderColor: "#775DD0",
              label: {
                orientation: "horizontal",
                borderColor: "#775DD0",
                style: {
                  color: "#fff",
                  background: "#775DD0"
                },
                text: "X Axis Anno Vertical"
              }
            }
          ],
        },*/
        plotOptions: {
          bar: {
            horizontal: true,
            barHeight: '100%',
            //rangeBarGroupRows: true,
            /*dataLabels: {
              hideOverflowingLabels: true
            }*/
          }
        },
        dataLabels: {
          enabled: false,
          formatter: function(value, { seriesIndex, dataPointIndex, w }) {
            return w.config.series[seriesIndex].data[dataPointIndex].description
          },
          style: {
            fontWeight: 'bold',
            //colors:undefined
          }
        },
        xaxis: {
          type: 'datetime',
        },
        yaxis: {
          show: false
        },
        grid: {
          row: {
            colors: ['#f3f4f5', '#fff'],
            opacity: 1
          }
        },
        stroke: {            
          width: 3
        },
        fill: {
          type: 'solid',
          opacity: 0.6,
        },
        legend: {
          horizontalAlign: 'left',
          show:false
        },
        tooltip: {
          custom: function({ series, seriesIndex, dataPointIndex, w }) {
            const date = () => {
              if ( new Date(w.config.series[seriesIndex].data[dataPointIndex].y[1]) - new Date(w.config.series[seriesIndex].data[dataPointIndex].y[0]) === 86400000){
                return new Date(w.config.series[seriesIndex].data[dataPointIndex].y[0]).toLocaleDateString()
              } else {
                return  new Date(w.config.series[seriesIndex].data[dataPointIndex].y[0]).toLocaleDateString() + " - " +  new Date(w.config.series[seriesIndex].data[dataPointIndex].y[1]).toLocaleDateString()
              }
            }
            return (
              '<div class="tooltip">' +
              '<div class="has-text-weight-bold">' + w.config.series[seriesIndex].data[dataPointIndex].description + '</div>' +
              '<div style="color:'+w.config.series[seriesIndex].data[dataPointIndex].fillColor+'">' + w.config.series[seriesIndex].data[dataPointIndex].theme + '</div>' +
                date() + 
              '</div>'
            )
          }
        },
        colors:this.colors,
        chart: {
          id: 'chart',
          defaultLocale: this.lang,
          locales: [{
            name: 'fr',
            options: {
              months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
              shortMonths: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc']
            }
          }],
          events: {
            dataPointSelection: (event, chartContext, config) => {
              this.openEventModal(config.w.config.series[config.seriesIndex].data[config.dataPointIndex])
            }
          },
          toolbar: { 
            show: false
          },
          animations: {
            enabled: false
          }
        }
      }
    }
  },
  watch: {
    'events': {
      handler: async function() {
         if(this.dataReady) {
          await this.calculateSeries()
          this.updateZoom()
        }
      },
      deep:true
    },
    'thematics': {
      handler: async function() {
         if(this.dataReady) {
          await this.calculateSeries()
          this.updateZoom()
        }
      },
      deep:true
    },
    'km': {
      handler: async function() {
         if(this.dataReady) {
          await this.calculateSeries()
          this.updateZoom()
        }
      },
      deep:true
    },
    'relationships': {
      handler: async function() {
         if(this.dataReady) {
          await this.calculateSeries()
          this.updateZoom()
        }
      },
      deep:true
    },
    'zoom': {
      handler: function() {
        if(this.dataReady) {
          this.updateZoom()
        }
      },
      deep:true
    },
    async lang(){
      if(this.dataReady) {
        await this.calculateSeries()
        this.updateZoom()
      }
    },
    async open(){
      if(this.dataReady) {
        await this.calculateSeries()
        this.updateZoom()
      }
    }
  },
  methods:{
    eventDates(start_year,start_month,start_day,end_year,end_month,end_day){
      return [
        new Date(start_year,start_month || 0, start_day || 1).getTime(),
        new Date(end_year || start_year,end_month || start_month || 0, end_day || start_day+1 || 2).getTime()
      ]
    },
    async calculateSeries(){   
      /*const series = this.activeThemes.map(theme => {
        let events = this.events
        if(this.activeRelationships.length !== 0){
          events = events.filter(event => this.activeRelationships.filter(id => event.from_events.map(from => from.relationship_id).includes(id)).length > 0
          || this.activeRelationships.filter(id => event.to_events.map(to => to.relationship_id).includes(id)).length > 0) 
        }
        events = events.filter(event => theme === event.theme['name_'+this.lang] && (event.km_up === null || event.km_up >= this.km[0]) && (event.km_down === null || event.km_down <= this.km[1]))
        const datas = events.map(event => {
          return {
            x: event.theme.thematic['name_'+this.lang],
            y:this.eventDates(event.start_year,event.start_month,event.start_day,event.end_year,event.end_month,event.end_day),
            description: event['title_'+this.lang],
            id: event.id
          }
        }) 
        return {
          name: theme,
          data: datas
        }
      })
      this.series = series*/

      return new Promise(resolve => {  
        let filterEvents = this.events
        if(this.activeRelationships.length !== 0){
          filterEvents = filterEvents.filter(event => this.activeRelationships.filter(id => event.from_events.map(from => from.relationship_id).includes(id)).length > 0
          || this.activeRelationships.filter(id => event.to_events.map(to => to.relationship_id).includes(id)).length > 0) 
        }
        filterEvents = filterEvents.filter(event => this.activeThemes.includes(event.theme['name_'+this.lang])  && (event.km_up >= this.km[0] && event.km_down <= this.km[1]) )
        this.eventsIds(filterEvents)
        const datas = filterEvents.map(event => {
          return {
            x: event.theme['name_'+this.lang],
            y:this.eventDates(event.start_year,event.start_month,event.start_day,event.end_year,event.end_month,event.end_day),
            description: event['title_'+this.lang],
            theme: event.theme['name_'+this.lang],
            id: event.id,
            fillColor: event.theme.color,
            strokeColor: event.theme.color
          }
        })

        this.series = [{name: 'events', data: datas}]

        const min = Math.min(...filterEvents.map(event => event.start_year))
        const max = Math.max(...filterEvents.map(event => event.end_year))
        this.zoom = [min, max]
        let arr = []
        for(let i = min; i <= new Date().getFullYear(); i += this.gap){
          arr.push(i)
        }
        this.steps = arr
        resolve()
      }) 
    },
    eventsIds(events){
      const ids = events.map(event => event.id)
      this.$store.commit('eventsIds',ids)
    },
    openEventModal(props){
      this.modalEvent = props
      this.ismodalEventActive = true
    },
    updateZoom() {
      if(this.$refs.chart !== undefined){
        this.$refs.chart.zoomX( new Date(this.zoom[0].toString()).getTime(), new Date(this.zoom[1].toString()).getTime())
      } 
    }
  }
}
</script>

<style scoped>
 .tooltip{
   padding: 5px;
 }
 .b-slider{
   margin:2.5em 0;
 }
 #chart{
   margin-top:20px;
 }
</style>
