<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="CreateRelation">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('relationships.title-create')}}</p>
        </header>
        <section class="modal-card-body">
          <ValidationProvider rules="required" name="name_fr" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.name_fr')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.name_fr"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="name_en" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.name_en')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.name_en"></b-input>
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
  name: 'CreateRelation',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      form: {
        name_fr: '',
        name_en: ''
      }
    }
  },
  methods: {
    async CreateRelation() {
      try{
        const response = await axios.post('admin/relationships', this.form)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('relationships.created'),
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