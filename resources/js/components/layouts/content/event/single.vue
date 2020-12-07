<template>
  <div>
    <template v-if="ismodalEditActive">
      <edit-event @refresh="$store.dispatch('getEvents')" v-bind="editEvent" has-modal-card trap-focus @close="$parent.close()"></edit-event>
    </template>
    <div class="modal-card" v-else>
      <header class="modal-card-head has-background-link">
        <div class="columns">
          <div class="column is-6">
            <p class="modal-card-title has-text-white has-text-weight-bold">{{event['title_'+lang]}}</p>
          </div>
          <div class="column is-4">
            <h2 v-if="event.theme" class="subtitle has-text-white is-size-6 has-text-weight-bold">{{$t('single.thematic')}}: <span class="has-text-white has-text-weight-normal">{{event.theme.thematic['name_'+lang]}}</span></h2>
            <h2 v-if="event.theme" class="subtitle has-text-white is-size-6 has-text-weight-bold">{{$t('single.theme')}}: <span class="has-text-white has-text-weight-normal">{{event.theme['name_'+lang]}}</span></h2>
          </div>
          <div class="column is-2">
            <div class="buttons is-right">
              <b-button v-if="isAdmin || isEditor" @click="ismodalEditActive = true" class="button is-success" icon-right="pencil mdi-24px" />
              <b-button @click="$parent.close()" icon-right="close mdi-24px" />
            </div>
          </div>
        </div>
      </header>
      <section class="modal-card-body">
        <div class="columns">
          <div class="column">
            <b-carousel v-if="event.images && event.images.length > 0">
              <b-carousel-item v-for="(image, index) in event.images" :key="index">
                <section class="hero is-primary">
                  <div class="image">
                    <img :src="'/storage/'+image.filename" :alt="image.filename">
                  </div>
                  <div class="hero-foot">
                    <div class="notification is-primary">
                        <p>{{image['legend_'+lang]}}</p>
                        <p v-if="image.copyright">Copyright : {{image.copyright}}</p>
                    </div>
                  </div>
                </section>
              </b-carousel-item>
            </b-carousel>
            <div v-if="event['description_'+lang]">
              <h2 class="subtitle has-text-primary is-5">{{$t('single.description')}}</h2>
              <div class="ql-editor content" v-html="event['description_'+lang]"></div>
            </div>
            <div v-if="event['bibliography_'+lang]">
              <hr class="separator">
              <h2 class="subtitle has-text-primary is-5">{{$t('single.bibliography')}}</h2>
              <div class="ql-editor content" v-html="event['bibliography_'+lang]"></div>
            </div>
            <div v-if="(isAdmin || isEditor) && event.creator">
              <hr class="separator">
              <h2 class="subtitle has-text-primary is-5">{{$t('single.creator')}} :</h2>
              <span>{{event.creator}}</span>
            </div>
          </div>
          <div class="column"> 
            <h2 class="subtitle has-text-primary is-size-5">{{$t('single.period')}}</h2>
            <div class="is-link">
              <table class="table is-fullwidth has-background-link has-text-white">
                <thead>
                  <tr>
                    <td class="has-text-white" v-if="event.start_day"><b>{{$t('single.start_day')}}</b></td>
                    <td class="has-text-white" v-if="event.start_month"><b>{{$t('single.start_month')}}</b></td>
                    <td class="has-text-white" v-if="event.start_year"><b>{{$t('single.start_year')}}</b></td>
                    <td class="has-text-white" v-if="event.end_day"><b>{{$t('single.end_day')}}</b></td>
                    <td class="has-text-white" v-if="event.end_month"><b>{{$t('single.end_month')}}</b></td>
                    <td class="has-text-white" v-if="event.end_year"><b>{{$t('single.end_year')}}</b></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td v-if="event.start_day">{{event.start_day}}</td>
                    <td v-if="event.start_month">{{monthName(event.start_month)}}</td>
                    <td v-if="event.start_year">{{event.start_year}}</td>
                    <td v-if="event.end_day">{{event.end_day}}</td>
                    <td v-if="event.end_month">{{monthName(event.end_month)}}</td>
                    <td v-if="event.end_year">{{event.end_year}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <single-map v-if="Object.keys(event).length > 0" :geom="event" :key="singleMapKey"></single-map>
          </div>
        </div>
        <hr class="separator">
        <div class="relationships">
          <h2 class="subtitle has-text-primary">{{$t('single.relationships')}}</h2>
          <div class="columns">
            <div class="column is-4">
              <h3 v-if="event.from_events && event.from_events.length > 0" class="subtitle is-5">{{$t('single.previous')}}</h3>
              <div class="content">
                <ul>
                  <li v-for="(from, idx) in event.from_events" :key="idx" v-on:click="linkToEvent(from)">
                    <a>{{ from['title_'+lang] }}</a>
                  </li >
                </ul>
              </div>
            </div>
            <div class="column is-4 is-offset-4">
              <h3 v-if="event.to_events && event.to_events.length > 0" class="subtitle is-5">{{$t('single.next')}}</h3>
              <div class="content">
                <ul>
                  <li v-for="(to, idx) in event.to_events" :key="idx" v-on:click="linkToEvent(to)">
                    <a>{{ to['title_'+lang] }}</a>
                  </li >
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import singleMap from './../map/singleMap'
import editEvent from './edit'
import { mapGetters } from 'vuex'
export default {
  name: "singleEvent",
  props: ['id'],
  components: {
    singleMap,
    editEvent
  },
  data() {
    return {
      event: {},
      singleMapKey: 0,
      ismodalEditActive: false,
    }
  },
  computed: {
    ...mapGetters(['isAdmin','isEditor']),
    editEvent(){
      return {event:this.event}
    },
    lang(){
      return this.$i18n.locale
    }
  },
  async mounted() {
    await this.loadEventData(this.id)
  },
  methods: {
    async loadEventData(id) {
        try{
        const response = await axios.get('/event/'+id)
        this.event = response.data
      }
      catch(error) {
        throw error
      }
    },
    async linkToEvent(event) {
      await this.loadEventData(event.id)
      this.singleMapKey += 1
    },
    monthName(month){
      return new Date(2020, month, 1).toLocaleString('default', { month: 'long' })
    }
  }  
}
</script>

<style scoped>
  .modal-card-head {
    display: block !important;
  }
  .subtitle {  
    margin-bottom: 0.5rem !important;
  }
  .ql-editor{
    min-height: auto !important;
  }
  .ql-editor >>> .ql-align-center {
    text-align: center;
  }
  .ql-editor >>> .ql-align-left {
    text-align: left;
  }
  .ql-editor >>> .ql-align-center {
    text-align: right;
  }
  .ql-editor >>> .ql-align-justify {
    text-align: justify;
  }
</style>