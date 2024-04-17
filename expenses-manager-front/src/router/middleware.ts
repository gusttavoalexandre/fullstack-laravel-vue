import Cookie from '../boot/cookie'
import { api } from 'boot/axios'
import { useUserStore } from 'stores/useUserStore'

export default {
  async redirectIfNotAuthenticated(to: any, from: any, next: any) {
    const store = useUserStore()
    const token = Cookie.getToken()
    let n

    if (!token) {
      n = { name: 'login' }
    }

    // Verificar se o token está valido
    await api
      .get('/auth/me')
      .then((response) => {
        store.storeUser(response.data)
      })
      .catch(() => {
        Cookie.deleteToken()
        n = { name: 'login' }
      })

    next(n)
  },
  redirectIfAuthenticated(to: any, from: any, next: any) {
    const token = Cookie.getToken()
    let n

    if (token) {
      n = { name: 'home' }
    }

    next(n)
  }
}
