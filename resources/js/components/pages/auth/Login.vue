<template>
  <div class="container">
    <div class="column is-4 is-offset-4">
      <login-form />
    </div>
  </div>
</template>

<script>
import LoginForm from "./../../auth/LoginForm"
export default {
  name: "Login",
  components: {
    LoginForm,
  }
}
</script>
<style scoped>
  .container{
    margin-top:70px;
  }
</style>

