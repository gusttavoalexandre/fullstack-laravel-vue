import { defineStore } from 'pinia'
type User = {
  name: string
  email?: string
}

export const useUserStore = defineStore('user', {
  state: () => ({
    user: {},
    authenticated: false
  }),
  getters: {
    authUser(state) {
      return state.user
    }
  },
  actions: {
    storeUser(user: User) {
      this.authenticated = true
      this.user = user
    },
    logout() {
      this.authenticated = false
      this.user = {}
    }
  }
})
