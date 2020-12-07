<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="EditThematic">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('thematics.title-update')}}</p>
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
          <b-field :label="$t('fields.themes')">
            <b-taginput v-model="form.themes" :data="themes" autocomplete open-on-focus append-to-body :placeholder="$t('fields.themes')" :field="'name_'+lang" icon="label" @typing="getFiltered($event,'themes','filteredThemes','name')" type="is-success">
              <template slot-scope="props">
                {{ props.option['name_'+lang] }}
              </template>
              <template slot="empty">
                {{$t('thematics.no-themes')}}
              </template>
              <template slot="footer">
                <a @click="createTheme = true">
                  <span> {{$t('common.add-new')}} </span>
                </a> 
              </template>
            </b-taginput>
          </b-field>
        </section>
        <footer class="modal-card-foot">
          <b-button size="is-medium" type="is-success" native-type="submit" :disabled="invalid" icon-right="floppy mdi-24px" />
          <b-button size="is-medium" @click="$parent.close()" icon-right="cancel mdi-24px" />
        </footer>
        <b-modal :active.sync="createTheme" has-modal-card :canCancel="[]">
          <create-theme @refresh="getThemes"></create-theme>
        </b-modal>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
import CreateTheme from './../../admin/themes/Create'
import { ValidationObserver, ValidationProvider } from "vee-validate"
export default {
  name: 'EditThematic',
  components: {
    CreateTheme,
    ValidationObserver,
    ValidationProvider
  },
  props: ['form'],
  data() {
    return {
      themes: [],
      filteredThemes: [],
      createTheme: false
    }
  },
  created() {
    this.getThemes()
  },
  computed: {
    lang(){
      return this.$i18n.locale
    }
  },
  methods: {
    async getThemes() { 
      try {
        const themes = await axios.get('themes')
        this.themes = themes.data
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
    getFiltered(text, data, filterdata, field) {
      this[filterdata] = this[data].filter((option) => {
        return option[field+'_'+this.lang].toString().toLowerCase().indexOf(text.toLowerCase()) >= 0
      })
    },
    async EditThematic() {
      try {
        const updateform = Object.assign({},this.form)
        updateform.themes = this.form.themes.map((theme) => {return theme.id})
        const response = await axios.put('admin/thematics/' +  updateform.id,  updateform)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('thematics.updated'),
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