<template>
  <section class="sidebar-layout">
    <b-sidebar
        type="is-light"
        position="static"
        mobile="fullwidth"
        :fullheight="fullheight"
        :fullwidth="fullwidth"
        :right="right"
        :open.sync="open"
      >
      <div class="p-1">
        <b-collapse style="margin-top:30px;" v-if="$route.name === 'Map'" :open="false" class="card">
          <div slot="trigger" slot-scope="props" class="card-header">
            <p class="card-header-title">{{$t('sidebar.mapstyle')}}</p>
            <a class="card-header-icon">
              <b-icon :icon="props.open ? 'menu-up' : 'menu-down'"></b-icon>
            </a>
          </div>
          <div class="card-content">
            <div class="content">
              <div class="field" v-bind:key="index" v-for="(layer, index) in filters.maplayers">
                <b-switch size="is-small" v-model="layer.active">{{layer.name}}</b-switch>
              </div>
            </div>
          </div>
        </b-collapse>
        <p class="menu-label">{{$t('sidebar.thematics')}}</p>
        <b-collapse :open="false" class="card" v-bind:key="index" v-for="(thematic, index) in filters.thematics" >
          <div slot="trigger" slot-scope="props" class="card-header">
            <p class="card-header-title">{{thematic['name_'+lang]}}</p>
            <a class="card-header-icon">
              <b-icon :icon="props.open ? 'menu-up' : 'menu-down'"></b-icon>
            </a>
          </div>
          <div class="card-content">
            <div class="content">
              <div class="field" v-bind:key="index" v-for="(theme, index) in thematic.themes">
                <b-switch size="is-small" v-model="theme.active"><b-icon icon="square" size="is-small" :style="{color:theme.color}"></b-icon><span>{{theme['name_'+lang]}}</span></b-switch>
              </div>
            </div>
          </div>
        </b-collapse>
        <p class="menu-label">{{$t('sidebar.distance')}}</p>
        <b-menu>
          <b-field>
            <b-slider lazy v-model="filters.km" :min="0" :max="550" :step="5" :custom-formatter="val => val+' km'">
              <template v-for="val in steps">
                  <b-slider-tick :value="val" :key="val">{{ val }}</b-slider-tick>
                </template>
            </b-slider>
          </b-field>
        </b-menu>
        <watermap/>
        <p class="menu-label">{{$t('sidebar.relationships')}}</p>
        <div class="field" :key="'R'+index" v-for="(relation, index) in filters.relationships">
          <b-switch size="is-small" v-model="relation.active">{{relation['name_'+lang]}}</b-switch>
        </div>
        <p class="menu-label">{{$t('sidebar.export')}}</p>
        <div class="buttons has-addons is-centered">
          <a class="button" @click="Export('xlsx')">
            <b-icon icon="file-excel"></b-icon>
            <span>Excel</span>
          </a>
          <a class="button" @click="Geojson()">
            <b-icon icon="code-json"></b-icon>
            <span>Geojson</span>
          </a>
        </div>
        <div v-if="eventsIds.length > 0" class="has-text-centered has-text-primary">
          {{eventsIds.length}}
          <span v-if="eventsIds.length > 1">{{$t('events.title')}}</span>
          <span v-else>{{$t('fields.event')}}</span>
        </div>
      </div>
    </b-sidebar>
  </section>
</template>


<script>
import { mapState } from "vuex"
import Watermap from './Watermap'
import download from "js-file-download"
export default {
  name: "Sidebar",
  components: {
    Watermap,
  },
  data() {
    return {
      fullheight: true,
      fullwidth: false,
      right: false,
      steps:[100, 200, 300, 400,500],
      isFullPage: true
    }
  },
  computed: {
    ...mapState({
      open:state => state.filters.open,
      filters:state => state.filters,
      eventsIds:state => state.data.eventsIds
    }),
    lang(){
      return this.$i18n.locale
    }
  },
  watch: {
    'filters.km': {
      handler: function() {
        this.$store.commit('selectedKm',this.filters.km)
      },
      deep: true
    },
    'filters.thematics': {
      handler: function() {
        this.$store.commit('selectedThematics',this.filters.thematics)
      },
      deep: true
    },
    'filters.relationships': {
      handler: function() {
        this.$store.commit('selectedRelationships',this.filters.relationships)
      },
      deep: true
    },
    'filters.maplayers': {
      handler: function() {
        this.$store.commit("selectedMaplayers", this.filters.maplayers);
      },
      deep: true
    },
  },
  created(){
    this.$store.dispatch('getThematics'),
    this.$store.dispatch('getRelationships')
  },
  methods:{
    async Export(type) {
      const loading = this.$buefy.loading.open({
        container: this.isFullPage ? null : this.$refs.element.$el
      })
      let response = await axios.post(
        "events/export",
        {
          ids: this.eventsIds,
          type: type
        },
        {
          responseType: "blob"
        }
      )
      download(
        response.data,
        "events." + type,
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
      )
      loading.close()
    },
    async Geojson() {
      const loading = this.$buefy.loading.open({
        container: this.isFullPage ? null : this.$refs.element.$el
      })
      let response = await axios.post(
        "events/geojson",
        {
          ids: this.eventsIds
        },
        {
          responseType: "blob"
        }
      );
      download(response.data, "events.geojson", "application/json")
      loading.close()
    }
  }  
}
</script>
<style scoped>
.mapstyle{
  margin-top:20px;
}
.p-1 {
  padding: 1em;
}
</style>
