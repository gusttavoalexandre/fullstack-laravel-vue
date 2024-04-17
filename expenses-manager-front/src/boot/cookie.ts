import { Cookies } from 'quasar'

const TOKEN_NAME = '_token'

export default {
  setToken(token: string) {
    Cookies.set(TOKEN_NAME, token, { expires: 30 })
  },

  getToken() {
    return Cookies.get(TOKEN_NAME)
  },

  deleteToken() {
    Cookies.remove(TOKEN_NAME)
  }
}
