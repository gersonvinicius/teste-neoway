import Vue from 'vue'
import { createLocalVue, shallowMount, Wrapper } from '@vue/test-utils'
import Vuex, { Store } from 'vuex'
import Vuetify from 'vuetify'
import Navigation from '@/components/Navigation.vue'
import { State } from '@/store/navigation'

Vue.use(Vuetify)

const localVue = createLocalVue()
localVue.use(Vuex)

let mockStore: Store<State>
let wrapper: Wrapper<any>

describe('Navigation', () => {
  beforeEach(() => {
    mockStore = new Vuex.Store({
      modules: {
        navigation: {
          namespaced: true,
          state: {
            items: [
              { icon: 'mdi-home', text: 'Dashboard', link: 'index' }
            ]
          }
        }
      }
    })

    wrapper = shallowMount(Navigation, { store: mockStore, localVue })
  })

  test('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('the navigation is available', () => {
    expect(wrapper.vm.items).toStrictEqual([{ icon: 'mdi-home', link: 'index', text: 'Dashboard' }])
  })
})
