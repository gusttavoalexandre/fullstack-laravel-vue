import { boot } from 'quasar/wrappers'
import axios from 'axios'
import Cookie from './cookie';
const api = axios.create({ baseURL: 'http://localhost:80/api' })

api.defaults.headers.common['Content-Type'] = 'application/json'
api.defaults.headers.common['Accept'] = 'application/json'

api.interceptors.request.use(function (config) {
  const token = Cookie.getToken()

  if (token) {
    config.headers['Authorization'] = token
  }

  return config
})

export default boot(({ app }) => {
  app.config.globalProperties.$axios = axios
  app.config.globalProperties.$api = api
})

export { axios, api }
