<template>
  <div class="modal-card">
    <header class="modal-card-head has-background-link">
      <div class="columns">
        <div class="column is-10">
          <p class="modal-card-title has-text-white">{{$t('events.select-event')}}</p>
        </div>
        <div class="column is-2">
          <div class="buttons is-right">
            <b-button @click="$parent.close()" icon-right="close mdi-24px" />
          </div>
        </div>
      </div>
    </header>
    <section class="modal-card-body">
      <div class="modal-card-content" id="content">
        <b-field v-if="events.length > 1">
            <b-select v-model="selectedEvent" :placeholder="$t('events.select-event')" expanded>
                <option 
                    v-for="option in events"
                    :value="option.properties"
                    :key="option.properties.id">
                    {{ option.properties.title }} : {{ option.properties.date }}
                </option>
            </b-select>
        </b-field>
         
      </div>
    </section>
    <footer class="modal-card-foot"></footer>
  </div>
</template>

<script>
import singleEvent from './../event/single'
export default {
  components: {
    singleEvent
  },
  name: "selectEvent",
  props: ["events"],
  data() {
    return {
      selectedEvent: null,
    }
  },
  watch: {
    selectedEvent() {
      this.$parent.close()
      this.$buefy.modal.open({
        parent: this,
        hasModalCard: true,
        canCancel:[],
        component: singleEvent,
        props: this.selectedEvent
      })
    }
  }
}
</script>

<style>
.modal-card-head {
  display: block !important;
}
</style>