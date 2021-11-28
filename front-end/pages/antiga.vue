<template>
  <v-container class="mt-6">
    <v-row no-gutters>
      <v-col cols="6" class="pa-2">
        <v-card>
          <v-sheet
            class="v-sheet--offset mx-auto"
            color="blue lighten-4"
            elevation="12"
            max-width="calc(100% - 32px)"
          >
            <v-sparkline
              :labels="labels"
              :value="value"
              color="black"
              line-width="2"
              padding="16"
            />
          </v-sheet>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              User Registrations
            </div>
            <div class="subheading font-weight-light grey--text">
              Last Campaign Performance
            </div>
            <v-divider class="my-2" />
            <v-icon
              class="mr-2"
              small
            >
              mdi-clock
            </v-icon>
            <span class="caption grey--text font-weight-light">last registration 26 minutes ago</span>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="6" class="pa-2">
        <v-card>
          <v-sheet
            class="v-sheet--offset mx-auto"
            color="blue lighten-4"
            elevation="12"
            max-width="calc(100% - 32px)"
          >
            <v-sparkline
              :labels="labels"
              :value="value"
              color="black"
              line-width="2"
              padding="16"
            />
          </v-sheet>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Page Views
            </div>
            <div class="subheading font-weight-light grey--text">
              Today page views
            </div>
            <v-divider class="my-2" />
            <v-icon
              class="mr-2"
              small
            >
              mdi-clock
            </v-icon>
            <span class="caption grey--text font-weight-light">last update 4 minutes ago</span>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<style>
  .v-sheet--offset {
    top: -24px;
    position: relative;
  }
</style>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  data: () => ({
    labels: [
      '12am',
      '3am',
      '6am',
      '9am',
      '12pm',
      '3pm',
      '6pm',
      '9pm'
    ],
    value: [
      200,
      675,
      410,
      390,
      310,
      460,
      250,
      240
    ]
  }),
  mounted () {
    this.$store.commit('updateTitle', 'Dashboard')
  }
})
</script>
