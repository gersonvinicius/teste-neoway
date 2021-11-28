<template>
  <v-dialog v-model="dialogState" max-width="500px">
    <v-card>
      <v-card-title>
        <span class="headline">Editar documento</span>
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
  props: {
    dialog: Boolean,
    doc: {
      type: Object as () => Doc,
      default: {
        number: '',
      }
    }
  },
  data () {
    return {
      valid: true, // If the form is valid
      errorMessage: '', // Default dialog error message
      docData: this.doc as Doc,
      rules: {
        required: (value: string) => !!value || 'Digite um cpf válido.',
      }
    }
  },
  computed: {

    // The state of the dialog is deferred to the parent component
    // because he's responsible of the user to edit
    dialogState: {
      get (): boolean {
        return this.dialog
      },
      set (val: boolean) {
        if (!val) {
          this.close()
        }
      }
    }
  },
  watch: {
    doc (doc: Doc) {
      this.docData = doc
    }
  },
  methods: {

    // Close the dialog
    close () {
      this.$emit('dialogWasClosed')
      this.resetForm()
    },

    resetForm () {
      this.docData = {
        number: '',
      }
    },

    // Save the user
    async save () {
      // Define type for the form. We doing this because we want typescript to understand the validator.
      const form = this.$refs.form as Vue & Validator

      if (form.validate() && (cpf.isValid(this.docData.number) || cnpj.isValid(this.docData.number))) {
        try {
          // Send the request to create the user to the api
          await this.$axios.$patch('http://127.0.0.1:8000/api/doc/' + this.docData.id, {
            number: this.docData.number,
          })

          this.$emit('docWasUpdated', this.docData)

          // Close the dialog
          this.close()
        } catch (error) {
          // If we have a form validation error from the pia
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
