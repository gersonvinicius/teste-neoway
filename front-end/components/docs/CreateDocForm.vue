<template>
  <v-dialog v-model="dialog" max-width="500px">
    <template v-slot:activator="{ on }">
      <v-btn color="primary" dark class="mb-2" v-on="on">
        Criar documento
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">Criar documento</span>
      </v-card-title>

      <v-card-text>
        <v-form
          ref="form"
          v-model="valid"
          lazy-validation
        >
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-alert v-if="errorMessage" type="error">
                  {{ errorMessage }}
                </v-alert>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-text-field v-model="docData.number" label="Number" :rules="[rules.required]" required />
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn color="blue darken-1" text @click="close">
          Cancel
        </v-btn>
        <v-btn color="blue darken-1" text @click="save">
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import Vue from 'vue'
import { Doc, Validator } from '~/types'
import { cpf, cnpj } from 'cpf-cnpj-validator';

export default Vue.extend({
  data () {
    return {
      dialog: false,
      valid: true, // If the form is valid
      errorMessage: '', // Default dialog error message
      docData: {
        number: '',
      } as Doc,
      rules: {
        required: (value: string) => !!value || 'Digite um cpf ou cnpj válido.',
      }
    }
  },
  watch: {
    dialog (val: boolean) {
      // Reset the form when the dialog was closed
      if (!val) {
        this.resetForm()
      }
    }
  },
  methods: {

    // Close the dialog
    close () {
      this.dialog = false
    },

    resetForm () {
      this.docData = {
        number: '',
      }

      // Define type for the form. We doing this because we want typescript to understand the validator.
      const form = this.$refs.form as Vue & Validator

      form.resetValidation()
    },

    // Save the user
    async save () {
      // Define type for the form. We doing this because we want typescript to understand the validator.
      const form = this.$refs.form as Vue & Validator

      if (form.validate() && (cpf.isValid(this.docData.number) || cnpj.isValid(this.docData.number))) {
        try {
          // Send the request to create the user to the api
          const response = await this.$axios.$post('http://127.0.0.1:8000/api/doc', {
            number: this.docData.number,
          })

          this.$emit('docWasCreated', response.data)

          // Close the form
          this.close()
        } catch (error) {
          // If we have a form validation error from the api
          if (error.response.status === 422) {
            this.valid = false

            const responseData = error.response.data.error
          }
        }
      }
    }
  }
})
</script>
