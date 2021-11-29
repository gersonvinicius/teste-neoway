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
    // trás todos os documentos via API
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

    editDoc (doc: Doc) { // abre a tela de edit carregando o registro selecionado
      this.editDocIndex = this.docs.indexOf(doc)
      this.editDocDialog = true
      this.docToEdit = Object.assign({}, doc)
    },

    async deleteDoc (doc: Doc) {
      if (confirm('Are you sure you want to delete this document?')) {
        try {
          // envia requisição pra excluir um registro
          await this.$axios.$delete('http://127.0.0.1:8000/api/doc/' + doc.id)

          this.$emit('docWasDeleted', doc)

          this.docs.splice(this.docs.indexOf(doc), 1)

        } catch (error) {
          // todo do something
        }
      }
    },

    async onDocWasCreated (doc: Doc) {
      // quando é criado um novo registro, ele carrega novamente todos
      this.docs = await this.$axios.$get('http://127.0.0.1:8000/api/doc');
    },

    onDocWasUpdated (doc: Doc) {
      // quando atualiza o registro
      Object.assign(this.docs[this.editDocIndex], doc)
      this.resetEditDoc()
    },

    onEditDocDialogClosed () {
      // efeito abrir e fechar modal
      this.editDocDialog = false
      this.resetEditDoc()
    },

    resetEditDoc () {
      // reseta os campos do modal
      this.editDocIndex = -1
      this.docToEdit = {
        number: '',
      }
    }
  }
})
</script>
