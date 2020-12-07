<template>
  <ValidationObserver ref="observer" v-slot="{ invalid }">
    <form @submit.prevent="EditEvent">
      <div class="modal-card">
        <header class="modal-card-head has-background-link">
          <div class="columns">
          <div class="column is-10">
            <p class="modal-card-title has-text-white">{{event['title_'+lang]}}</p>
          </div>
          <div class="column is-2">
            <div class="buttons is-right">
              <b-button @click="$emit('close')" icon-right="close mdi-24px" />
            </div>
          </div>
        </div>
        </header>
        <section class="modal-card-body">
          <ValidationProvider rules="required" name="title" v-slot="{ errors, valid }">
            <b-field :label="$t('fields.title')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-input type="text" v-model="event['title_'+lang]"></b-input>
            </b-field>
          </ValidationProvider>
          <ValidationProvider rules="required" name="theme" v-slot="{ errors, valid }">
            <b-field :label="$t('single.theme')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
              <b-select v-model="event.theme.id">
                <option v-for="option in themes" :value="option.id" :key="option.id">
                  {{ option["name_"+lang] }}
                </option>
              </b-select>
            </b-field>
          </ValidationProvider>
          <div v-if="isAdmin || isEditor">
            <ValidationProvider rules="required" name="author" v-slot="{ errors, valid }">
              <b-field  :label="$t('single.author')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                <b-select v-model="event.author_id">
                  <option v-for="option in users" :value="option.id" :key="option.id">
                    {{ option.firstname }} {{ option.name }}
                  </option>
                </b-select>
              </b-field>
            </ValidationProvider>
          </div>
          <div class="columns">
            <div class="column">
              <ValidationProvider rules="numeric" name="start_day" v-slot="{ errors, valid }">
                <b-field :label="$t('single.start_day')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-numberinput v-model="event.start_day"></b-numberinput>
                </b-field>
              </ValidationProvider>
            </div>
            <div class="column">
              <ValidationProvider rules="numeric" name="start_month" v-slot="{ errors, valid }">
                <b-field :label="$t('single.start_month')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-numberinput v-model="event.start_month"></b-numberinput>
                </b-field>
              </ValidationProvider>
            </div>
            <div class="column">
              <ValidationProvider rules="required|numeric" name="start_year" v-slot="{ errors, valid }">
                <b-field :label="$t('single.start_year')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-numberinput v-model="event.start_year"></b-numberinput>
                </b-field>
              </ValidationProvider>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <ValidationProvider rules="numeric" name="end_day" v-slot="{ errors, valid }">
                <b-field :label="$t('single.end_day')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-numberinput v-model="event.end_day"></b-numberinput>
                </b-field>
              </ValidationProvider>
            </div>
            <div class="column">
              <ValidationProvider rules="numeric" name="end_month" v-slot="{ errors, valid }">
                <b-field :label="$t('single.end_month')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-numberinput v-model="event.end_month"></b-numberinput>
                </b-field>
              </ValidationProvider>
            </div>
            <div class="column">
              <ValidationProvider rules="numeric" name="end_year" v-slot="{ errors, valid }">
                <b-field :label="$t('single.end_year')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-numberinput v-model="event.end_year"></b-numberinput>
                </b-field>
              </ValidationProvider>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <ValidationProvider rules="regex:^[0-9.]+$" name="km_up" v-slot="{ errors, valid }">
                <b-field :label="$t('single.km_up')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-input type="text" v-model="event.km_up"></b-input>
                </b-field>
              </ValidationProvider>
            </div>
            <div class="column">
              <ValidationProvider rules="regex:^[0-9.]+$" name="km_down" v-slot="{ errors, valid }">
                <b-field :label="$t('single.km_down')" :type="{ 'is-danger': errors[0], 'is-success': valid }" :message="errors">
                  <b-input type="text" v-model="event.km_down"></b-input>
                </b-field>
              </ValidationProvider>
            </div>
          </div>
          <media @selection="imageSelection" :selectedImages="event.images"></media>
          <b-field :label="$t('single.description')">
            <vue-editor id="description" :customModules="customModulesForEditor" :editorOptions="editorSettings" v-model="event['description_'+lang]"></vue-editor>
          </b-field>
          <b-field :label="$t('single.bibliography')">
            <vue-editor id="bibliography" :customModules="customModulesForEditor" :editorOptions="editorSettings" v-model="event['bibliography_'+lang]"></vue-editor>
          </b-field>
          <b-field :label="$t('single.geometries')">
            <edit-map :geom="event"></edit-map>
          </b-field>
          <b-field :label="$t('single.previous')">
            <b-table
              :data="event.from_events"
              default-sort="id">
              <template v-if="event.from_events.length >0">
                <b-table-column field="event" :label="$t('fields.event')" sortable centered v-slot="props">
                  {{ props.row['title_'+lang] }}
                </b-table-column>
                <b-table-column field="relationship_id" :label="$t('fields.relation')" sortable centered v-slot="props">
                  {{ relationshipName(props.row.relationship_id) }}
                </b-table-column>
                <b-table-column field="action" :label="$t('common.actions')" v-slot="props">
                  <div class="buttons">
                    <b-button type="is-danger" @click="deleteRelation('from',props.row)" icon-right="delete mdi-24px"/>        
                  </div>
                </b-table-column>
              </template>
              <template slot="footer">
                <th>
                  <b-field>
                    <b-autocomplete v-model="fromRelatedEvent" :data="fromFilteredEvents" field="title_fr" :placeholder="$t('fields.event')" expanded @select="option => (fromSelectedEvent = option)">
                      <template slot="empty">No results found</template>
                    </b-autocomplete>
                  </b-field>
                </th>
                <th>
                  <b-field v-if="fromSelectedEvent">
                    <b-select v-model="fromSelectedEvent.relationship_id" :placeholder="$t('fields.relation')" expanded>
                      <option v-for="option in relationships" :value="option.id" :key="option.id">
                        {{ option["name_"+lang] }}
                      </option>
                    </b-select>
                  </b-field>
                </th>
                <th>
                    <div class="buttons">
                    <b-button type="is-info" @click="addRelation('from',fromSelectedEvent)" icon-right="plus mdi-24px"/>        
                  </div>
                </th>
              </template>
            </b-table>
          </b-field>
          <b-field :label="$t('single.next')">
            <b-table
              :data="event.to_events"
              default-sort="id">
              <template v-if="event.to_events.length >0">
                <b-table-column field="event" :label="$t('fields.event')" sortable centered v-slot="props">
                  {{ props.row['title_'+lang] }}
                </b-table-column>
                <b-table-column field="relationship_id" :label="$t('fields.relation')" sortable centered v-slot="props">
                  {{ relationshipName(props.row.relationship_id) }}
                </b-table-column>
                <b-table-column field="action" :label="$t('common.actions')" v-slot="props">
                  <div class="buttons">
                    <b-button type="is-danger" @click="deleteRelation('to',props.row)" icon-right="delete mdi-24px"/>        
                  </div>
                </b-table-column>
              </template>
              <template slot="footer">
                <th>
                  <b-field>
                    <b-autocomplete v-model="toRelatedEvent" :data="toFilteredEvents" field="title_fr" :placeholder="$t('fields.event')" expanded @select="option => (toSelectedEvent = option)">
                      <template slot="empty">No results found</template>
                    </b-autocomplete>
                  </b-field>
                </th>
                <th>
                  <b-field  v-if="toSelectedEvent">
                    <b-select v-model="toSelectedEvent.relationship_id" :placeholder="$t('fields.relation')" expanded>
                      <option v-for="option in relationships" :value="option.id" :key="option.id">
                        {{ option["name_"+lang] }}
                      </option>
                    </b-select>
                  </b-field>
                </th>
                <th>
                  <div class="buttons">
                    <b-button type="is-info" @click="addRelation('to',toSelectedEvent)" icon-right="plus mdi-24px"/>        
                  </div>
                </th>
              </template>
            </b-table>
          </b-field>
        </section>
        <footer class="modal-card-foot">
          <b-button size="is-medium" type="is-success" native-type="submit" :disabled="invalid" icon-right="floppy mdi-24px" />
          <b-button size="is-medium" @click="$emit('close')" icon-right="cancel mdi-24px" />
        </footer>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate"
import { VueEditor, Quill } from "vue2-editor"
import { ImageDrop } from "quill-image-drop-module"
import ImageResize from "quill-image-resize-module"
import axios from "axios"
import media from './media'
import editMap from './../map/editMap'
import { mapGetters } from 'vuex'

export default {
  name: "editEvent",
  components: {
    ValidationObserver,
    ValidationProvider,
    VueEditor,
    editMap,
    media
  },
  props: ['event'],
  data() {
    return {
      themes: [],
      users: [],
      events: [],
      relationships: [],
      fromRelatedEvent:'',
      toRelatedEvent:'',
      fromSelectedEvent: null,
      toSelectedEvent: null,
      customModulesForEditor: [{ alias: "imageDrop", module: ImageDrop }, { alias: "imageResize", module: ImageResize }],
      editorSettings: {
        modules: {
          imageDrop: true,
          imageResize: {
            modules: [ 'Resize', 'DisplaySize' ]
          }
        }
      }
    }
  },
  computed:{
    ...mapGetters(['isAdmin','isEditor']),
    lang(){
      return this.$i18n.locale
    },
    fromFilteredEvents() {
      return this.events.filter(option => {
        return option["title_"+this.lang].toString().toLowerCase().indexOf(this.fromRelatedEvent.toLowerCase()) >= 0
      })
    },
    toFilteredEvents() {
      return this.events.filter(option => {
        return option["title_"+this.lang].toString().toLowerCase().indexOf(this.toRelatedEvent.toLowerCase()) >= 0
      })
    }
  },
  created() {
    this.getData('themes','themes')
    this.getData('users','users')
    this.getData('events/list','events')
    this.getData('relationships','relationships')
  },
  methods: {
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
    imageSelection(images){
      this.event.images = images
    },
    relationshipName(id){
      if(this.relationships.length > 0){
        return this.relationships.find(relation => relation.id === id)["name_"+this.lang]
      }
    },
    addRelation(direction,row){
      this.event[direction+"_events"].push(row)
      if(direction === 'to') {
        this.toSelectedEvents = null
        this.toRelatedEvent = ''
      } else {
        this.fromSelectedEvents = null
        this.fromRelatedEvent = ''
      }
    },
    deleteRelation(direction,row){
      this.event[direction+"_events"].splice(this.event[direction+"_events"].indexOf(row), 1)
    },
    async EditEvent() {
      try {
        const response = await axios.put('event/' +  this.event.id,  this.event)
        if(response.status === 200){
          this.$buefy.snackbar.open({
            message: this.$t('events.updated'),
            position: 'is-top',
            type: 'is-success'
          })
          this.$emit('close')
          this.$emit('refresh')
        }
      }
      catch(error) {
        let message = error.response.data.message
        for (let [key, value] of Object.entries(error.response.data.errors)){
          message += '<p>'+value+'</p>'
        }
        this.$buefy.snackbar.open({
          message: message,
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
  .modal-card-head {
    display: block !important;
  }
</style>