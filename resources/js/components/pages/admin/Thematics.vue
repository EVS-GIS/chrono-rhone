<template>
  <div class="container">
    <h3 class="title">{{$t('thematics.title')}}
      <span>
        <b-button rounded type="is-primary" @click="createFormisActive = true" icon-right="plus mdi-24px"/>
      </span>
    </h3>
    <b-modal :active.sync="createFormisActive" has-modal-card :canCancel="[]">
      <create-thematic @refresh="loadData"></create-thematic>
    </b-modal>
    <b-field :label="$t('thematics.filter')">
      <b-input v-model="search" />
    </b-field>
    <b-table 
    detailed
    custom-detail-row
    ref="table"
    detail-key="name_fr"
    :row-class="(row, index) => 'thematics'"
    :data="isEmpty ? [] : SearchbyName" 
    :loading="loading" 
    :paginated="isPaginated" 
    :per-page="perPage" 
    :pagination-simple="isPaginationSimple" 
    :default-sort-direction="defaultSortDirection"
    default-sort="name_fr">
      <template>
        <b-table-column field="ranking" :label="$t('fields.ranking')" numeric sortable centered v-slot="props">
          {{ props.row.ranking }}
        </b-table-column>
        <b-table-column field="name_fr" :label="$t('fields.name_fr')" sortable centered v-slot="props">
          {{ props.row.name_fr }}
        </b-table-column>
        <b-table-column field="name_en" :label="$t('fields.name_en')" sortable centered v-slot="props">
          {{ props.row.name_en }}
        </b-table-column>
        <b-table-column field="themes" :label="$t('fields.themes')" sortable centered v-slot="props">
           <b-tag rounded type="is-primary">{{ props.row.themes.length }}</b-tag>
        </b-table-column>
        <b-table-column field="action" :label="$t('common.actions')" v-slot="props">
          <div class="buttons">
            <b-button type="is-success" @click="editModal(props.row)" icon-right="pencil mdi-24px"/>
            <b-button type="is-danger" @click="confirmDelete(props.row)" icon-right="delete mdi-24px"/>                 
          </div>
        </b-table-column>
      </template>
      <template slot="detail" slot-scope="props">
        <tr v-for="item in props.row.themes" :key="item.name_fr">
          <td></td>
          <td></td>
          <td class="has-text-centered">{{ item.name_fr }}</td>
          <td class="has-text-centered">{{ item.name_en }}</td>
          <td></td>
        </tr>
      </template>
      <template slot="empty">
        <section class="section">
          <div class="content has-text-grey has-text-centered">
            <p>
              <b-icon icon="emoticon-sad" size="is-large">
              </b-icon>
            </p>
            <p>{{$t('thematics.no-themes')}}</p>
          </div>
        </section>
      </template>
    </b-table>
  </div>
</template>

<script>
  import CreateThematic from './../../admin/thematics/Create'
  import EditThematic from './../../admin/thematics/Edit'
  export default {
    components: {
      CreateThematic,
    },
    data() {
      return {
        data: [],
        search: '',
        loading: false,
        isEmpty: false,
        isPaginated: true,
        isPaginationSimple: false,
        defaultSortDirection: 'asc',
        currentPage: 1,
        perPage: 25,
        createFormisActive: false
      }
    },
    computed: {
      lang(){
        return this.$i18n.locale
      },
      SearchbyName() {
        return this.data.filter(data => {
          return data['name_'+this.lang].toLowerCase().includes(this.search.toLowerCase())
        })
      }
    },
    created() {
      this.loadData()
    },
    methods: {
      async loadData() {
        try{
          this.loading = true
          const response = await axios.get('/thematics')
          if(response.status === 200){
            this.data = response.data
            this.loading = false
          }
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
      confirmDelete(row) {
        this.$buefy.dialog.confirm({
          title: this.$t('thematics.delete-thematic'),
          message: this.$t('thematics.confirm-delete-thematic'),
          confirmText: this.$t('common.delete'),
          cancelText: this.$t('common.cancel'),
          type: 'is-danger',
          hasIcon: true,
          onConfirm: () => this.delete(row)
        })
      },
      async delete(row) {
        try{
          const response = await axios.delete('admin/thematics/' + row.id)
          if(response.status === 200){
            this.data.splice(this.data.indexOf(row), 1)
            this.$buefy.snackbar.open({
              message: this.$t('thematics.deleted'),
              position: 'is-top',
              type: 'is-success'
            })
          }
        }
        catch(error) {
          this.$buefy.snackbar.open({
            message: error.response.data.message,
            position: 'is-top',
            type: 'is-danger',
          })
          this.loading = false
          throw error
        }
      },
      editModal(row) {
        this.$buefy.modal.open({
          parent: this,
          props: {
            form: row,
          },
          events: {
            refresh: this.loadData
          },
          component: EditThematic,
          hasModalCard: true,
          canCancel: []
        })
      }
    }
  }
</script>

<style>
.thematics {
  font-weight: bold;
}
</style>