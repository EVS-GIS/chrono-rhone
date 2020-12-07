<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="deleteUser">
      <div class="modal-card">
        <header class="modal-card-head has-background-link">
          <div class="columns">
            <div class="column is-10">
              <p class="modal-card-title has-text-white" v-html="$t('users.confirm-delete-my-account')"></p>
            </div>
            <div class="column is-2">
              <div class="buttons is-right">
                <b-button @click="$parent.close()" icon-right="close mdi-24px" />
              </div>
            </div>
          </div>
        </header>
        <section class="modal-card-body">
          <div class="modal-card-content" id="content">
            <ValidationProvider rules="required" name="theme" v-slot="{ errors, valid }">
              <b-field :label="$t('users.select-user')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-select v-model="selectedUser" :placeholder="$t('events.select-user')" expanded>
                      <option 
                          v-for="option in users"
                          :value="option.id"
                          :key="option.id">
                          {{ option.firstname }} {{ option.name }}
                      </option>
                  </b-select>
              </b-field>
            </ValidationProvider>            
          </div>
        </section>
        <footer class="modal-card-foot">
          <b-button size="is-medium" @click="$parent.close()">{{$t('common.cancel')}}</b-button>
          <b-button size="is-medium" type="is-danger" native-type="submit" :disabled="invalid">{{$t('common.delete')}}</b-button>
        </footer>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate"
export default {
  name: "SelectUser",
  props: ["id"],
  components: {
    ValidationObserver,
    ValidationProvider
  },
  created() {
    this.getUsers()
  },
  data() {
    return {
      users: [],
      selectedUser: null,
    }
  },
  methods:{
    async getUsers() {
      try{
        const response = await axios.get('users')
        if(response.status === 200){
          this.users = response.data.filter(user => user.id !== this.id)
        }
      }
      catch(error) {
        this.$buefy.snackbar.open({
          message: error.response.data.message,
          position: 'is-top',
          type: 'is-danger'
        })
        this.users = []
        throw error
      }
    },
    async deleteUser() {
      try{
        const response = await axios.put('events/update_user/'+ this.id,{'new_user_id':this.selectedUser})
        if(response.status === 200){
          await axios.delete('admin/users/' + this.id)

          await this.$store.dispatch("AUTH_LOGOUT")
          this.$router.push("/")
          this.$buefy.snackbar.open({
            message: this.$t('users.deleted'),
            position: 'is-top',
            type: 'is-success'
          })
          this.$parent.close()
        }
      }
      catch(error) {
        this.$buefy.snackbar.open({
          message: error.response.data.message,
          position: 'is-top',
          type: 'is-danger'
        })
        throw error
      }
    }
  }
}
</script>

<style>
.modal-card-head {
  display: block !important;
}
</style>