<template>
  <div>
    <v-navigation-drawer v-model="drawer" color="primary" app dark>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Nuxt
          </v-list-item-title>
          <v-list-item-subtitle>
            Sample Application
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider />
      <v-list>
        <v-list-item v-for="item in items" :key="item.text" link :to="{ name: item.link}" nuxt>
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>
              {{ item.text }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar color="white" elevation="0" app>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title class="mr-5 align-center">
        <span class="title">{{ title }}</span>
      </v-toolbar-title>
    </v-app-bar>
  </div>
</template>

<style scoped>
</style>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  data () {
    return {
      drawer: true
    }
  },
  computed: {
    items () {
      return this.$store.state.navigation.items
    },
    title () {
      return this.$store.state.title
    }
  }
})
</script>
