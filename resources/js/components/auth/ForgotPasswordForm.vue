<template>
  <div class="forgot-password-form">
    <div class="box">
      <p>{{$t('forgot-password.description')}}</p>
      <ValidationObserver ref="observer" v-slot="{ invalid }">
        <form @submit.prevent="forgot">
          <ValidationProvider rules="required|email" name="email" v-slot="{ errors, valid }">
            <b-field
              :label="$t('fields.email')"
              :type="{ 'is-danger': errors[0], 'is-success': valid }"
              :message="errors"
            >
              <b-input type="email" v-model="form.email"></b-input>
            </b-field>
          </ValidationProvider>
          <b-button :loading="loading" class="button is-block is-info is-large is-fullwidth" native-type="submit" :disabled="invalid">
            {{$t('forgot-password.submit')}}
          </b-button>
        </form>
      </ValidationObserver>
    </div>
    <b-notification type="is-success" v-show="isSend">
      {{$t('forgot-password.success')}}
    </b-notification>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate"
export default {
  name: "ForgotPasswordForm",
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      form: {
        email: ''
      },
      loading: false,
      isSend: false
    };
  },
  methods: {
    async forgot() {
      try{
        this.loading = true
        const response = await axios.post("auth/password/email", this.form)
        if(response.status === 200){
          this.isSend = true
          this.loading = false
        }
      }
      catch(error) {
        this.loading = false
        this.form.email = ""
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
