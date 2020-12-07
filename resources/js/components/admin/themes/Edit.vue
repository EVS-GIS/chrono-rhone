<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="EditTheme">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('themes.title-update')}}</p>
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
          <ValidationProvider rules="required|numeric" name="ranking" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.ranking')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-numberinput v-model="form.ranking"></b-numberinput>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="color" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.color')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <v-swatches v-model="form.color" show-fallback popover-x="right" swatches="text-advanced"></v-swatches>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="thematic" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.thematic')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-select v-model="form.thematic.id">
                <option v-for="option in thematics" :value="option.id" :key="option.id">
                  {{ option['name_'+lang] }}
                </option>
              </b-select>
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
import VSwatches from 'vue-swatches'
export default {
  name: 'EditTheme',
  components: {
    ValidationObserver,
    ValidationProvider,
    VSwatches
  },
  props: ['form'],
  data() {
    return {
      thematics: [],
    }
  },
  computed: {
    lang(){
      return this.$i18n.locale
    }
  },
  created() {
    this.getThematics()
  },
  methods: {
    async getThematics() { 
      try {
        const response = await axios.get('thematics')
        this.thematics = response.data
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
    async EditTheme() {
      try {
        let updateform = Object.assign({},this.form)
        updateform.thematic_id = updateform.thematic.id
        const response = await axios.put('admin/themes/' +  updateform.id,  updateform)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('themes.updated'),
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

<style lang="scss" scoped>
  @import "~vue-swatches/dist/vue-swatches.css";
</style>