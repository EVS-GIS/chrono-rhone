<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="EditRole">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('roles.title-update')}}</p>
        </header>
        <section class="modal-card-body">
          <ValidationProvider rules="required" name="slug" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.slug')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.slug"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="name" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.name')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.name"></b-input>
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
  name: 'EditRole',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  props: ['form'],
  methods: {
    async EditRole() {
      try {
        const response = await axios.put('admin/roles/' +  this.form.id,  this.form)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('roles.updated'),
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

<style scoped>
</style>