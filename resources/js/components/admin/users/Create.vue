<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="CreateUser">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('users.title-create')}}</p>
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
          <ValidationProvider rules="required" name="role" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.role')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-select v-model="form.role">
                <option v-for="option in roles" :value="option.id" :key="option.id">
                  {{ option.name }}
                </option>
              </b-select>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required|min:8" vid="password" name="password" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.password')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="password" v-model="form.password" password-reveal></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required|confirmed:password" name="password_confirmation" v-slot="{ errors, valid }">
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
export default {
  name: 'CreateUser',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      roles: [],
      form: {
        firstname: '',
        name: '',
        organization:'',
        email: '',
        role: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  created() {
    this.getRoles()
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
    async CreateUser() {
      try{
        const response = await axios.post('admin/users', this.form)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('users.created'),
            position: 'is-top',
            type: 'is-success'
          })
          this.$parent.close()
          this.$emit('refresh')
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