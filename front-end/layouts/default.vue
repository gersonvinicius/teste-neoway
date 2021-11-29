<template>
  <v-app dark>
    <Navigation />
    <v-content>
      <Nuxt />
    </v-content>
  </v-app>
</template>

<style scoped>
</style>

<script lang="ts">
import Vue from 'vue'
import Navigation from '~/components/Navigation.vue'

export default Vue.extend({
  components: {
    Navigation
  }
})
</script>
