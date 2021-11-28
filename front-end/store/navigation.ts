export interface State {
  items: Array<object>
}

export const state = () => ({
  items: [
    { icon: 'mdi-home', text: 'Dashboard', link: 'index' },
  ]
}) as State
