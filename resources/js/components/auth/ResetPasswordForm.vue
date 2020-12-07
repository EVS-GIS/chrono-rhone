<template>
  <div class="reset-password-form">
    <div class="box">
      <h1 class="title is-4">{{$t('reset-password.title')}}</h1>
      <ValidationObserver ref="observer" v-slot="{ invalid }">
      <form @submit.prevent="reset">
        <ValidationProvider rules="required|email" name="email" v-slot="{ errors, valid }">
          <b-field :label="$t('fields.email')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
            <b-input type="email" v-model="form.email"></b-input>
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
        <b-button :loading="loading" class="button is-block is-info is-large is-fullwidth" native-type="submit" :disabled="invalid">
          {{$t('common.validate')}}
        </b-button>
      </form>
      </ValidationObserver>
    </div>
    <b-notification type="is-success" v-show="isReset">
      {{$t('reset-password.success')}}
      <router-link :to="{ path: '/login'}">{{$t('login.connect')}}</router-link>
    </b-notification>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate"
export default {
  name: "ResetPasswordForm",
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      form: {
        token: this.$route.params.token,
        email: "",
        password: null,
        password_confirmation: null
      },
      loading: false,
      isReset: false
    };
  },
  methods: {
    async reset() {
      try{
        this.loading = true
        const response = await axios.post("auth/password/reset", this.form)
        if(response.status === 200){
          this.isReset = true
          this.loading = false
        }
      }
      catch(error) {
        this.loading = false
        this.form.password = null
        this.form.password_confirmation = null
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
