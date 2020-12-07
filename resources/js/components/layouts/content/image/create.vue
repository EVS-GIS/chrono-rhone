<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="CreateImage">
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{$t('images.title-create')}}</p>
        </header>
        <section class="modal-card-body">
          <ValidationProvider rules="required|mimes:image/jpeg,image/png" name="image" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.image')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-upload v-model="form.file" native drag-drop expanded>
                <section class="section">
                  <div class="content has-text-centered">
                    <p>
                      <b-icon icon="upload" size="is-large"></b-icon>
                    </p>
                    <p>{{$t('fields.upload')}}</p>
                  </div>
                </section>
              </b-upload>
            </b-field>
            <div v-if="form.file" class="tags">
              <span class="tag is-primary" >
                {{form.file.name}}
                <button class="delete is-small" type="button" @click="deleteDropFile()"></button>
              </span>
            </div>
          </ValidationProvider>
          <ValidationProvider rules="required" name="legend" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.legend')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="textarea" v-model="form['legend_'+lang]"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="copyright" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.copyright')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="form.copyright"></b-input>
            </b-field>
          </ValidationProvider>
          <b-field :label="$t('fields.events')">
            <b-taginput v-model="linkedEvents" :data="filteredEvents" autocomplete open-on-focus append-to-body :placeholder="$t('fields.events')" :field="'title_'+lang" icon="label" @typing="getFiltered($event,'events','filteredEvents','title')" type="is-success">
              <template slot-scope="props">
                {{ props.option['title_'+lang] }}
              </template>
              <template slot="empty">
                {{$t('events.no-events')}}
              </template>
            </b-taginput>
          </b-field>
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
  name: 'CreateImage',
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      form: {
        file: null,
      },
      linkedEvents:[],
      events: [],
      filteredEvents: [],
      dataUrl: null
    }
  },
  created() {
    this.getData('events/list','events')
  },
  computed:{
    lang(){
      return this.$i18n.locale
    },
    formdata() {
      let finalForm = this.form
      finalForm.events = this.linkedEvents.map(event=>event.id)
      const formData = new FormData()
      for (let key in finalForm) {
        Array.isArray(finalForm[key])
        ? finalForm[key].forEach(value => formData.append(key + '[]', value))
        : formData.append(key, finalForm[key]) ;
      }
      return formData
    }
  },
  methods: {
    deleteDropFile() {
      this.form.file = null
    },
    async getData(url,ressource){
      try {
        const response = await axios.get(url)
        this[ressource] = response.data
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
    async CreateImage() {
      try{
        const response = await axios.post('upload/image', this.formdata)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('images.created'),
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