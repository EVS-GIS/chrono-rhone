<template>
  <div class="container">
    <h3 class="title">{{$t('events.title')}}
      <span>
        <b-button rounded type="is-primary" @click="createFormisActive = true" icon-right="plus mdi-24px"/>
      </span>
    </h3>
    <b-modal :active.sync="createFormisActive" has-modal-card :canCancel="[]">
      <create-event @refresh="loadData"></create-event>
    </b-modal>
    <b-field :label="$t('events.filter')" grouped>
      <b-input v-model="search" expanded/>
      <b-switch v-model="myEvents">{{$t('events.only-mine')}}</b-switch>
    </b-field>
    <b-table :data="isEmpty ? [] : SearchbyName" :loading="loading" :paginated="isPaginated" :per-page="perPage" :pagination-simple="isPaginationSimple" :default-sort-direction="defaultSortDirection" default-sort="id">
      <template>
        <b-table-column field="id" :label="$t('fields.id')" sortable centered v-slot="props">
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="title" width="500" :label="$t('fields.title')" sortable centered v-slot="props">
          {{ props.row['title_'+lang] }}
        </b-table-column>
        <b-table-column field="theme" :label="$t('fields.theme')" sortable centered v-slot="props">
          {{ props.row.theme['name_'+lang] }}
        </b-table-column>
        <b-table-column field="author" :label="$t('fields.author')" sortable centered v-slot="props">
          {{ author(props.row.author_id) }}
        </b-table-column>
        <b-table-column field="action" :label="$t('common.actions')" v-slot="props">
          <div class="buttons">
            <b-button type="is-info" @click="showModal(props.row)" icon-right="eye-outline mdi-24px"/>
            <b-button v-if="showButtons(props.row.author_id)" type="is-success" @click="editModal(props.row)" icon-right="pencil mdi-24px"/>
            <b-button v-if="showButtons(props.row.author_id)" type="is-danger" @click="confirmDelete(props.row)" icon-right="delete mdi-24px"/>                 
          </div>
        </b-table-column>
      </template>
      <template slot="empty">
        <section class="section">
          <div class="content has-text-grey has-text-centered">
            <p>
              <b-icon icon="emoticon-sad" size="is-large">
              </b-icon>
            </p>
            <p>{{$t('events.no-events')}}</p>
          </div>
        </section>
      </template>
    </b-table>
  </div>
</template>

<script>
  import { mapGetters } from "vuex"
  import SingleEvent from './../../layouts/content/event/single'
  import CreateEvent from './../../layouts/content/event/create'
  import EditEvent from './../../layouts/content/event/edit'
  export default {
    components: {
      CreateEvent,
    },
    data() {
      return {
        data: [],
        users:[],
        search: '',
        loading: false,
        isEmpty: false,
        isPaginated: true,
        isPaginationSimple: false,
        defaultSortDirection: 'asc',
        currentPage: 1,
        perPage: 25,
        createFormisActive: false,
        myEvents: false
      }
    },
    computed: {
      ...mapGetters(["isAdmin","isEditor","isContributor","user"]),
      lang(){
        return this.$i18n.locale
      },
      SearchbyName() {
        if(!this.myEvents){
          return this.data.filter(data => {
            return data.title_fr.toLowerCase().includes(this.search.toLowerCase())
          })
        }
        return this.data.filter(data => {
          return data.author_id === this.user.id && data.title_fr.toLowerCase().includes(this.search.toLowerCase())
        })
      }
    },
    created() {
      this.loadData()
      this.getData('users','users')
    },
    methods: {
      async getNbPages (url) {
        const response = await axios.get(url)
        const pagesNumber = Number(response.data.meta.last_page)
        return pagesNumber
      },
      async loadData() {
        try{
          this.loading = true
          const callPages = []
          const pagesNumber = await this.getNbPages('/events')
          for (let i = 1; i <= pagesNumber; i++) {
            callPages.push(axios.get('/events' + '?page=' + i))
          }
          let responses = await axios.all(callPages)
          this.data = responses.map(response =>{
            return response.data.data
          }).flat()
          this.loading = false
        }
        catch(error) {
          this.$buefy.snackbar.open({
            message: error.response.data.message,
            position: 'is-top',
            type: 'is-danger'
          })
          this.data = []
          this.loading = false
          this.isEmpty = true
          throw error
        }
      },
      async getData(url,ressource){
        try {
          const response = await axios.get(url)
          this[ressource] = response.data
        }
        catch(error) {
          this.$buefy.snackbar.open({
            message: error.response.data.message,
            position: 'is-top',
            type: 'is-danger'
          })
          throw error
        }
      },
      confirmDelete(row) {
        this.$buefy.dialog.confirm({
          title: this.$t('events.delete-event'),
          message: this.$t('events.confirm-delete-event'),
          confirmText: this.$t('common.delete'),
          cancelText: this.$t('common.cancel'),
          type: 'is-danger',
          hasIcon: true,
          onConfirm: () => this.delete(row)
        })
      },
      async delete(row) {
        try{
          const response = await axios.delete('event/' + row.id)
          if(response.status === 200){
            this.data.splice(this.data.indexOf(row), 1)
            this.$buefy.snackbar.open({
              message: this.$t('events.deleted'),
              position: 'is-top',
              type: 'is-success'
            })
          }
        }
        catch(error) {
          this.$buefy.snackbar.open({
            message: error.response.data.message,
            position: 'is-top',
            type: 'is-danger'
          })
          this.loading = false
          throw error
        }
      },
      editModal(row) {
        this.$buefy.modal.open({
          parent: this,
          props: {
            event: row,
          },
          events: {
            refresh: this.loadData
          },
          component: EditEvent,
          hasModalCard: true,
          canCancel: []
        })
      },
      showModal(row) {
        this.$buefy.modal.open({
          parent: this,
          props: {
            id: row.id,
          },
          component: SingleEvent,
          hasModalCard: true,
          canCancel: []
        })
      },
      showButtons(userId){
        if(this.isAdmin || this.isEditor){
          return true
        }else if(userId === this.user.id){
          return true
        }
        return false
      },
      author(id){
        const user = this.users.find(user => user.id === id)
        return user.firstname +' '+user.name
      }
    }
  }
</script>

<style scoped>
</style>