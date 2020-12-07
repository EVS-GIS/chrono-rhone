<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="EditUser">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('users.title-update')}}</p>
        </header>
        <section class="modal-card-body">
          <ValidationProvider rules="required" name="firstname" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.firstname')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.firstname"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="name" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.name')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.name"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="organization" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.organization')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.organization"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required|email" name="email" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.email')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="email" v-model="form.email"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider v-if="isAdmin" rules="required" name="role" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.role')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-select v-model="form.role.id">
                <option v-for="option in roles" :value="option.id" :key="option.id">
                  {{ option.name }}
                </option>
              </b-select>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="min:8" vid="password" name="password" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.password')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="password" v-model="form.password" password-reveal></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="confirmed:password" name="password_confirmation" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.password_confirmation')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="password" v-model="form.password_confirmation" password-reveal></b-input>
            </b-field>
          </ValidationProvider>
        </section>
        <footer class="modal-card-foot">
          <b-button size="is-medium" type="is-success" native-type="submit" :disabled="invalid" icon-right="floppy mdi-24px" />
          <b-button size="is-medium" @click="$parent.close()" icon-right="cancel mdi-24px" />
        </footer>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate"
import { mapGetters } from "vuex"
export default {
  name: 'EditUser',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  props: ['form'],
  data() {
    return {
      roles: []
    }
  },
  created() {
    this.getRoles()
  },
  computed: {
    ...mapGetters(["isAdmin"]),
  },
  methods: {
    async getRoles() { 
      try {
        const roles = await axios.get('roles')
        this.roles = roles.data
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
    async EditUser() {
      try {
        let updateform = Object.assign({},this.form)
        updateform.role = updateform.role.id
        const response = await axios.put('admin/users/' +  updateform.id,  updateform)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('users.updated'),
            position: 'is-top',
            type: 'is-success'
          })
          this.$parent.close()
          this.$emit("refresh")
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

<style scoped>
</style>