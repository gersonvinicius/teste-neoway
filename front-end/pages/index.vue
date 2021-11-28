<template>
  <v-data-table
    :headers="headers"
    :items="docs"
    :search="search"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        />
        <v-spacer />
        <CreateDocForm @docWasCreated="onDocWasCreated" />
        <EditDocForm :dialog="editDocDialog" :doc="docToEdit" @docWasUpdated="onDocWasUpdated" @dialogWasClosed="onEditDocDialogClosed" />
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editDoc(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteDoc(item)"
      >
        mdi-delete
      </v-icon>
    </template>
  </v-data-table>
</template>

<script lang="ts">
import Vue from 'vue'
import CreateDocForm from '~/components/docs/CreateDocForm.vue'
import EditDocForm from '~/components/docs/EditDocForm.vue'
import { Doc } from '~/types'

export default Vue.extend({
  components: {
    CreateDocForm,
    EditDocForm
  },

  async asyncData ({ app }) {
    // Get all docs from the API
    const response = await app.$axios.$get('http://127.0.0.1:8000/api/doc')
    console.log(response)
    return {
      headers: [
        { text: 'Documento', align: 'start', value: 'number' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      docs: response
    }
  },
  data () {
    return {
      docs: [] as Array<any>,
      search: '',
      editDocDialog: false,
      editDocIndex: -1,
      docToEdit: {
        number: '',
      } as Doc
    }
  },
  mounted () {
    this.$store.commit('updateTitle', 'Docs')
  },
  methods: {

    editDoc (doc: Doc) {
      this.editDocIndex = this.docs.indexOf(doc) // @todo find a better way to do this
      this.editDocDialog = true
      this.docToEdit = Object.assign({}, doc)
    },

    async deleteDoc (doc: Doc) {
      if (confirm('Are you sure you want to delete this document?')) {
        try {
          // Send the request to create the user to the api
          await this.$axios.$delete('http://127.0.0.1:8000/api/doc/' + doc.id)

          this.$emit('docWasDeleted', doc)

          this.docs.splice(this.docs.indexOf(doc), 1)

          // Add the user add the beginning of the users table list
          // this.users.unshift(this.userData)
        } catch (error) {
          // todo do something
        }
      }
    },

    onDocWasCreated (doc: Doc) {
      console.log(doc)
      this.docs.unshift(doc)
    },

    onDocWasUpdated (doc: Doc) {
      Object.assign(this.docs[this.editDocIndex], doc)
      this.resetEditDoc()
    },

    onEditDocDialogClosed () {
      this.editDocDialog = false
      this.resetEditDoc()
    },

    resetEditDoc () {
      this.editDocIndex = -1
      this.docToEdit = {
        number: '',
      }
    }
  }
})
</script>
