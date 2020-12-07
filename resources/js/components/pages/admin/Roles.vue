<template>
  <div class="container">
    <h3 class="title">{{$t('roles.title')}}
      <span>
        <b-button rounded type="is-primary" @click="createFormisActive = true" icon-right="plus mdi-24px"/>
      </span>
    </h3>
    <b-modal :active.sync="createFormisActive" has-modal-card :canCancel="[]">
      <create-role @refresh="loadData"></create-role>
    </b-modal>
    <b-field :label="$t('roles.filter')">
      <b-input v-model="search" />
    </b-field>
    <b-table
      :data="isEmpty ? [] : SearchbyName"
      :loading="loading"
      :paginated="isPaginated"
      :per-page="perPage"
      :pagination-simple="isPaginationSimple"
      :default-sort-direction="defaultSortDirection"
      default-sort="id">
      <template>
        <b-table-column field="id" label="Id" numeric sortable centered v-slot="props">
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="slug" :label="$t('fields.slug')" sortable centered v-slot="props">
          {{ props.row.slug }}
        </b-table-column>
        <b-table-column field="name" :label="$t('fields.name')" sortable centered v-slot="props">
          {{ props.row.name }}
        </b-table-column>
        <b-table-column field="action" :label="$t('common.actions')" v-slot="props">
          <div class="buttons">
            <b-button type="is-success" @click="editModal(props.row)" icon-right="pencil mdi-24px"/>
            <b-button type="is-danger" @click="confirmDelete(props.row)" icon-right="delete mdi-24px"/>        
          </div>
        </b-table-column>
      </template>
      <template slot="empty">
        <section class="section">
          <div class="content has-text-grey has-text-centered">
            <p>
              <b-icon
                icon="emoticon-sad"
                size="is-large">
              </b-icon>
            </p>
            <p>{{$t('roles.no-roles')}}</p>
          </div>
        </section>
      </template>
    </b-table>
  </div>
</template>

<script>
import CreateRole from './../../admin/roles/Create'
import EditRole from './../../admin/roles/Edit'
export default {
  components: {
      CreateRole,
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
    SearchbyName() {
      return this.data.filter(data => {
        return data.name.toLowerCase().includes(this.search.toLowerCase())
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
        const response = await axios.get('roles')
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
        title: this.$t('roles.delete-role'),
        message: this.$t('roles.confirm-delete-role'),
        confirmText: this.$t('common.delete'),
        cancelText: this.$t('common.cancel'),
        type: 'is-danger',
        hasIcon: true,
        onConfirm: () => this.delete(row)
      })
    },
    async delete(row) {
      try{
        const response = await axios.delete('admin/roles/' + row.id)
        if(response.status === 200){
          this.data.splice(this.data.indexOf(row), 1)
          this.$buefy.snackbar.open({
            message: this.$t('roles.deleted'),
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
            form:row,
        },
        component: EditRole,
        hasModalCard: true,
        canCancel:[]
      })
    }
  }
}
</script>
<style scoped>
</style>