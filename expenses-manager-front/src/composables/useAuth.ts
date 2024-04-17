import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { api } from 'boot/axios'

import Cookie from '../boot/cookie'
import { useUserStore } from 'stores/useUserStore'
import dataFormat from '../boot/dataFormat'

type Login = {
  email: string
  password: string
}

type Errors = {
  name: string
  email: string
  password: string
  general: string,
  password_confirmation: string
}

type Register = {
  name: string
  email: string
  password: string
  password_confirmation: string
}

const useAuth = () => {
  const errors = ref<Errors>({
    name: '',
    email: '',
    password: '',
    general: '',
    password_confirmation: ''
  })
  const router = useRouter()
  const store = useUserStore()

  const login = async (params: Login) => {
    resetErrors()

    try {
      const response = await api.post('/auth/login', params)

      const token = `${response.data.token_type} ${response.data.access_token}`
      Cookie.setToken(token)
      router.push({ name: 'home' })
    } catch (e: any) {
      if (e.response.status === 422) {
        errors.value = dataFormat.formatErrors(e.response.data.errors)
      } else if (e.response.status === 401) {
        errors.value.general = e.response.data.message.toString()
      }
    }
  }

  const register = async (params: Register) => {
    resetErrors()

    try {
      const response = await api.post('/auth/register', params)

      const token = `${response.data.token_type} ${response.data.access_token}`
      Cookie.setToken(token)
      router.push({ name: 'home' })
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = dataFormat.formatErrors(e.response.data.errors)
      }
    }
  }

  const logout = async () => {
    try {
      await api.post('/auth/logout')
      Cookie.deleteToken()
      await router.push({ name: 'login' })
    } catch (e) {
      console.log('Internal error', e)
    }
  }

  const resetErrors = () => {
    errors.value = {
      name: '',
      email: '',
      password: '',
      general: '',
      password_confirmation: ''
    }
  }

  return {
    errors,
    login,
    register,
    logout,
    store
  }
}

export default useAuth
