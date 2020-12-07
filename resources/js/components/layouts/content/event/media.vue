<template>
  <div>
    <b-field :label="$t('fields.images')">
      <b-collapse :open="false" aria-id="selectImage">
        <b-button slot="trigger" aria-controls="selectImage" size="is-medium" @click="addImage" type="is-primary" icon-left="image">{{$t('images.select-image')}}</b-button>
        <section>
          <div class="box">
            <div class="block">
              <b-button @click="createFormisActive = true" type="is-info" icon-left="upload">{{$t('images.title-create')}}</b-button>
            </div>
            <span v-for="(image, index) in paginatedImages" :key="index" class="block">
              <b-checkbox v-model="selection" :native-value="image" @input="select" type="is-info">
                  <img class="image is-128x128" :src="'/storage/'+image.filename" :alt="image.filename" />
              </b-checkbox>
            </span>         
            <hr>
            <b-pagination
                :total="images.length"
                v-model="current"
                :per-page="perPage">
            </b-pagination>
          </div>
        </section>
      </b-collapse>
    </b-field>
    <b-modal :active.sync="createFormisActive" has-modal-card :canCancel="[]">
      <create-image @refresh="addImage"></create-image>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios"
import CreateImage from './../image/create'
export default {
  name: "media",
  props: ['selectedImages'],
  components: {
    CreateImage,
  },
  data() {
    return {
      images: [],
      selection:this.selectedImages,
      current: 1,
      perPage: 50,
      createFormisActive: false
    }
  },
  computed:{
    paginatedImages() {
      let page_number = this.current-1
      return this.images.slice(page_number * this.perPage, (page_number + 1) * this.perPage)
    }
  },
  methods: {
    async getNbPages (url) {
      const response = await axios.get(url)
      const pagesNumber = Number(response.data.meta.last_page)
      return pagesNumber
    },
    async addImage() {
      try{
        const callPages = []
        const pagesNumber = await this.getNbPages('/images')
        for (let i = 1; i <= pagesNumber; i++) {
          callPages.push(axios.get('/images' + '?page=' + i))
        }
        let responses = await axios.all(callPages)
        this.images = responses.map(response =>{
          return response.data.data
        }).flat()
      }
      catch(error) {
        this.$buefy.snackbar.open({
          message: error.response.data.message,
          position: 'is-top',
          type: 'is-danger'
        })
        this.images = []
        this.isEmpty = true
        throw error
      }
    },
    select(){
      this.$emit('selection', this.selection)
    }
  }
  
}
</script>