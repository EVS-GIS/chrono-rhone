<template>
  <div class="container">
    <h3 class="title">{{$t('images.title')}}
      <span>
        <b-button rounded type="is-primary" @click="createFormisActive = true" icon-right="plus mdi-24px"/>
      </span>
    </h3>
    <b-modal :active.sync="createFormisActive" has-modal-card :canCancel="[]">
      <create-image @refresh="loadData"></create-image>
    </b-modal>
    <b-field :label="$t('images.filter')" grouped>
      <b-input v-model="search" expanded/>
    </b-field>
    <b-table detailed detail-key="id" :data="isEmpty ? [] : SearchbyName" :loading="loading" :paginated="isPaginated" :per-page="perPage" :pagination-simple="isPaginationSimple" :default-sort-direction="defaultSortDirection" default-sort="id">
      <template>
        <b-table-column field="id" :label="$t('fields.id')" sortable centered v-slot="props">
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="image" width="150" :label="$t('fields.image')" centered v-slot="props">
          <b-image :src="'/storage/'+props.row.filename" :alt="props.row.filename" ratio="2by1"/>
        </b-table-column>
        <b-table-column field="filename" :label="$t('fields.filename')" sortable centered v-slot="props">
          {{ props.row.filename}}
        </b-table-column>
        <b-table-column field="events" :label="$t('fields.events')" sortable centered v-slot="props">
           <b-tag rounded type="is-primary">{{ props.row.events.length }}</b-tag>
        </b-table-column>
        <b-table-column field="action" :label="$t('common.actions')" v-slot="props">
          <div class="buttons">
            <b-button v-if="showButtons(props.row.author_id)" type="is-success" @click="editModal(props.row)" icon-right="pencil mdi-24px"/>
            <b-button v-if="showButtons(props.row.author_id)" type="is-danger" @click="confirmDelete(props.row)" icon-right="delete mdi-24px"/>                 
          </div>
        </b-table-column>
      </template>
      <template slot="detail" slot-scope="props">
        <div class="columns">
          <div class="column">
            <div class="content">
              <h2 class="subtitle is-6">{{$t('fields.legend')}}</h2>
              {{ props.row['legend_'+lang]}}
            </div>
          </div>
          <div class="column">
            <div class="content">
              <h2 class="subtitle is-6">{{$t('fields.copyright')}}</h2>
              {{ props.row.copyright}}
            </div>
          </div>
          <div v-if="props.row.events.length > 0" class="column">
            <div class="content">
              <h2 class="subtitle is-6">{{$t('fields.events')}}</h2>
              <ul v-for="item in props.row.events" :key="item.id">
                <li>{{ item['title_'+lang]}}</li>
              </ul>
            </div>
          </div>
        </div>
      </template>
      <template slot="empty">
        <section class="section">
          <div class="content has-text-grey has-text-centered">
            <p>
              <b-icon icon="emoticon-sad" size="is-large">
              </b-icon>
            </p>
            <p>{{$t('images.no-images')}}</p>
          </div>
        </section>
      </template>
    </b-table>
  </div>
</template>

<script>
  import { mapGetters } from "vuex"
  import CreateImage from './../../layouts/content/image/create'
  import EditImage from './../../layouts/content/image/edit'
  export default {
    components: {
      CreateImage,
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
        defaultSortDirection: 'desc',
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
            return data.filename.toLowerCase().includes(this.search.toLowerCase())
          })
        }
        return this.data.filter(data => {
          return data.author_id === this.user.id && data.filename.toLowerCase().includes(this.search.toLowerCase())
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
          const pagesNumber = await this.getNbPages('/images')
          for (let i = 1; i <= pagesNumber; i++) {
            callPages.push(axios.get('/images' + '?page=' + i))
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
          title: this.$t('images.delete-image'),
          message: this.$t('images.confirm-delete-image'),
          confirmText: this.$t('common.delete'),
          cancelText: this.$t('common.cancel'),
          type: 'is-danger',
          hasIcon: true,
          onConfirm: () => this.delete(row)
        })
      },
      async delete(row) {
        try{
          const response = await axios.delete('storage/' + row.filename)
          if(response.status === 200){
            this.data.splice(this.data.indexOf(row), 1)
            this.$buefy.snackbar.open({
              message: this.$t('images.deleted'),
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
            image: row,
          },
          events: {
            refresh: this.loadData
          },
          component: EditImage,
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