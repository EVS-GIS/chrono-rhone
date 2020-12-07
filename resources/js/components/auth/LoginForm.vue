<template>
  <div class="loginform">
    <div class="box">
      <ValidationObserver ref="observer" v-slot="{ invalid }">
        <form @submit.prevent="login">
          <ValidationProvider rules="required|email" name="email" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.email')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="email" v-model="credentials.email"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required|min:5" vid="password" name="password" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.password')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="password" v-model="credentials.password" password-reveal></b-input>
            </b-field>
          </ValidationProvider>
          <button class="button is-block is-info is-large is-fullwidth" type="submit" :disabled="invalid">
            {{$t('login.connect')}}
          </button>
        </form>
      </ValidationObserver>
    </div>
    <p class="has-text-grey">
      <router-link :to="{ name: 'ForgotPassword'}">{{$t('login.forgot-password')}}</router-link>
    </p>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate"
export default {
  name: "LoginForm",
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      credentials: {
        email: "",
        password: ""
      }
    }
  },
  methods: {
    async login() {
      try{
        await this.$store.dispatch("AUTH_REQUEST", this.credentials)
        this.$router.push("/timeline")
      }
      catch(error){
        this.credentials.password = ""
        requestAnimationFrame(() => {
          this.$refs.observer.reset()
        })
        this.$buefy.snackbar.open({
          message: error.response.data.message,
          position: "is-top",
          type: "is-danger"
        })
      }
    }
  }
}
</script>
<style scoped>
</style>

