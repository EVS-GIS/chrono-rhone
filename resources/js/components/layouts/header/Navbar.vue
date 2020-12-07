<template>
  <b-navbar class="is-link" fixed-top>
    <template slot="brand">
      <a href="https://ohm-vallee-du-rhone.in2p3.fr/" target="_blank">
        <img class="logo" src="./../../../assets/OHMVR.jpg" alt="OHM Vallée du Rhône"/>
      </a>
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        <h1>{{$t('nav.home')}}</h1>
      </b-navbar-item>
    </template>
    <template slot="start">
      <b-navbar-item v-if="$route.name === 'TimelinePage' || $route.name === 'Map'" tag="div">
        <b-button v-if="open" type="is-primary" @click="openFilters">
          {{$t('nav.close-filters')}}
        </b-button>
        <b-button v-else type="is-primary" @click="openFilters">
          {{$t('nav.open-filters')}}
        </b-button>
      </b-navbar-item>
      <b-navbar-item v-if="$route.name !== 'TimelinePage'" tag="router-link" :to="{ name: 'TimelinePage' }">
        {{$t('nav.timeline')}}
      </b-navbar-item>
      <b-navbar-item v-if="$route.name !== 'Map'" tag="router-link" :to="{ name: 'Map' }">
        {{$t('nav.map')}}
      </b-navbar-item>
      <b-navbar-item href="https://ohm-vallee-du-rhone.in2p3.fr/outils/frise-chronosystemique" target="_blank">
        {{$t('nav.use')}}
      </b-navbar-item>
    </template>
    <template slot="end">
      <lang-switcher/>
      <b-navbar-dropdown v-if="isAuthenticated" :label="$t('nav.account')" collapsible>
        <b-navbar-item tag="router-link" :to="{ name: 'Me' }">
          <b-icon icon="account" size="is-small"></b-icon>
          <span> {{user.firstname}} {{user.name}}</span>
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'Events' }">
          <b-icon icon="calendar" size="is-small"></b-icon>
          <span> {{$t('events.title')}}</span>
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'Images' }">
          <b-icon icon="image" size="is-small"></b-icon>
          <span> {{$t('images.title')}}</span>
        </b-navbar-item>
      </b-navbar-dropdown>
      <b-navbar-dropdown v-if="isAuthenticated && isAdmin" :label="$t('nav.admin-panel')" collapsible>
        <b-navbar-item tag="router-link" :to="{ name: 'Users' }">
          {{$t('users.title')}}
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'Roles' }">
          {{$t('roles.title')}}
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'Thematics' }">
          {{$t('thematics.title')}}
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'Themes' }">
          {{$t('themes.title')}}
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'Relationships' }">
          {{$t('relationships.title')}}
        </b-navbar-item>
      </b-navbar-dropdown>
      <b-navbar-item tag="router-link" :to="{ name: 'Documentation' }">
        API
      </b-navbar-item>
      <b-navbar-item tag="div">
        <div class="buttons">
          <b-button v-if="!isAuthenticated" type="is-primary" tag="router-link" :to="{ name: 'Login' }">
           {{$t('nav.login')}}
          </b-button>
          <b-button v-else type="is-light" @click="logout">
            {{$t('nav.logout')}}
          </b-button>
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
</template>


<script>
import { mapState,mapGetters } from "vuex"
import LangSwitcher from './LangSwitcher'

export default {
  name: "Navbar",
  components: {
    LangSwitcher,
  },
  data() {
    return {
      navIsActive: false,
    };
  },
  computed: {
    ...mapState({
      screen: state => state.screen,
      open:state => state.filters.open,
    }),
    ...mapGetters(["isAuthenticated", "isAdmin","isEditor","isContributor","user"])
  },
  methods: {
    async logout() {
      await this.$store.dispatch("AUTH_LOGOUT")
      this.$router.push("/")
    },
    openFilters(){
      this.$store.commit("open",!this.open)
    }
  }
}
</script>

<style scoped>
.logo {
  margin: 5px;
  max-height: 60px;
}
</style>
