<template>
  <div class="container">
    <div class="column is-4 is-offset-4">
      <reset-password-form />
    </div>
  </div>
</template>

<script>
import ResetPasswordForm from "./../../auth/ResetPasswordForm"
export default {
  name: "ResetPassword",
  components: {
    ResetPasswordForm,
  }
}
</script>
<style scoped>
  .container{
    margin-top:70px;
  }
</style>