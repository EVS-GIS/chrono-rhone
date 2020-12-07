<template>
  <div class="container">
    <div class="column is-4 is-offset-4">
      <forgot-password-form />
    </div>
  </div>
</template>

<script>
import ForgotPasswordForm from "./../../auth/ForgotPasswordForm"
export default {
  name: "ForgotPassword",
  components: {
    ForgotPasswordForm,
  }
}
</script>
<style scoped>
  .container{
    margin-top:70px;
  }
</style>