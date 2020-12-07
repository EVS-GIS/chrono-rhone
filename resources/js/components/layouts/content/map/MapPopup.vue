<template>
  <div class="content">
    <ul v-for="feature in features" :key="feature.properties.id">
      <li>
        <span :style="{color:feature.properties.color}">{{feature.properties.title}}</span>:
        <span>{{feature.properties.date}}</span>
      </li>
    </ul>
  </div>
</template>

<script>
import Vue from 'vue'
export default Vue.extend({
  props: {
    features: {
      required: true,
      type: Array,
    }
  },
  name: 'MapPopup'
})
</script>