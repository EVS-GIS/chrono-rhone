<template>
  <div class="container">
    <h2 class="title">{{user.firstname}} {{user.name}}
      <span>
        <b-button rounded type="is-success" @click="editModal(user)" icon-right="pencil mdi-24px"/>
      </span>
    </h2>
    <div class="line">
      <span class="subtitle has-text-primary">{{$t('fields.email')}} :</span>
      <span> {{user.email}}</span>
    </div>
    <div class="line">
      <span class="subtitle has-text-primary">{{$t('fields.organization')}} :</span>
      <span> {{user.organization}}</span>
    </div>
    <div class="line">
      <span class="subtitle has-text-primary">{{$t('fields.role')}} :</span>
      <span> {{user.role.name}}</span>
    </div>
    <div class="line">
      <b-button type="is-primary" @click="editModal(user)" icon-right="lock-reset mdi-24px"> {{$t('reset-password.title')}}</b-button>
    </div>
    <div v-if="user.role.slug === 'admin'" class="line">
      <b-loading is-full-page v-model="loading" :can-cancel="true"></b-loading>
      <form @submit.prevent="importDb">
        <ValidationObserver ref="observer" v-slot="{ invalid }">
          <b-collapse :open="false" aria-id="dbImport">
              <b-button slot="trigger" aria-controls="dbImport" type="is-primary" icon-right="database-import mdi-24px">{{$t('fields.database')}}</b-button>
              <section>
                <ValidationProvider rules="required|mimes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="image" v-slot="{ errors, valid }">
                  <b-upload v-model="file" native drag-drop expanded :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                    <section class="section">
                      <div class="content has-text-centered">
                        <p>
                          <b-icon icon="upload" size="is-large"></b-icon>
                        </p>
                        <p>{{$t('fields.upload')}}</p>
                      </div>
                    </section>
                  </b-upload>
                </ValidationProvider>
              </section>
              <div v-if="file" class="tags">
                <span class="tag is-primary" >
                  {{file.name}}
                  <button class="delete is-small" type="button" @click="deleteDropFile()"></button>
                </span>
              </div>
              <b-button size="is-medium" type="is-success" native-type="submit" :disabled="invalid" icon-right="database-import mdi-24px">{{$t('common.import')}}</b-button>
          </b-collapse>
        </ValidationObserver>
      </form>
    </div>
    <div class="line">
      <b-button type="is-danger" @click="deleteModal()" icon-right="delete mdi-24px"> {{$t('users.delete')}}</b-button>
    </div>
  </div>
  
</template>

<script>
import { mapGetters } from "vuex"
import EditUser from './../../admin/users/Edit'
import SelectUser from './../../admin/users/Select'
import { ValidationObserver, ValidationProvider } from "vee-validate"
export default {
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      user: {
        role:{}
      },
      file: null,
      loading: false,
    }
  },
  created() {
    this.loadData()
  },
  methods: {
    async loadData() {
      try{
        const response = await axios.get('auth/me')
        if(response.status === 200){
          this.user = response.data
        }
      }
      catch(error) {
        this.$buefy.snackbar.open({
          message: error.response.data.message,
          position: 'is-top',
          type: 'is-danger'
        })
        this.user = []
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
        component: EditUser,
        hasModalCard: true,
        canCancel: []
      })
    },
    confirmDelete(id) {
      this.$buefy.dialog.confirm({
        title: this.$t('users.delete-user'),
        message: this.$t('users.confirm-delete-my-account'),
        confirmText: this.$t('common.delete'),
        cancelText: this.$t('common.cancel'),
        type: 'is-danger',
        hasIcon: true,
        onConfirm: () => this.deleteUser(id)
      })
    },
    deleteModal(){
      this.$buefy.modal.open({
        parent: this,
        hasModalCard: true,
        canCancel:[],
        component: SelectUser,
        props: {id:this.user.id}
      })
    },
    deleteDropFile() {
      this.file = null
    },
    async importDb(){
      try{
        this.loading=true
        const formData = new FormData()
        formData.append("file", this.file)
        const response = await axios.post('admin/import', formData)
        if(response.status === 200){
          this.loading=false
          this.$buefy.snackbar.open({
            message: this.$t('database.imported'),
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
        this.file = null
        this.loading=false 
        throw error
      }
    }
  }
}
</script>
<style scoped>
  .line{
    margin-bottom: 20px;
  }
</style>