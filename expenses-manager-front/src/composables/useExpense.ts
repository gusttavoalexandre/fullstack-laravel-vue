import { ref, type Ref } from 'vue'
import { api } from 'boot/axios'
import { useRouter } from 'vue-router'
import dataFormat from '../boot/dataFormat'

type Expense = {
  id: number
  value: number
  description: string
  formatted_value: string
  date: string
  default_date_format: string
}

type ExpenseParams = {
  value: string
  description: string
  date: string
}

type Errors = {
  value: string
  description: string
  date: string
}

const useExpense = () => {
  const errors = ref<Errors>({
    value: '',
    description: '',
    date: ''
  })
  const router = useRouter()
  const expenses: Ref<Array<Expense>> = ref([])

  const index = async () => {
    try {
      const response = await api.get('/expenses')
      expenses.value = response.data.data
    } catch (e: any) {
      router.push('/unauthorized')
    }
  }

  const show = async (id: number): Promise<Expense | undefined> => {
    try {
      const response = await api.get(`/expenses/${id}`)
      return response.data.data
    } catch (e: any) {
      if (e.response?.status === 403) {
        router.push('/unauthorized')
      }
    }
  }

  const store = async (params: ExpenseParams) => {
    resetErrors()

    try {
      await api.post('/expenses', params)

      router.push('/expenses')
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = dataFormat.formatErrors(e.response.data.errors)
      }
    }
  }

  const update = async (id: number, params: ExpenseParams) => {
    try {
      const response = await api.put(`/expenses/${id}`, params)
      router.push({ name: 'expense.index' })
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = dataFormat.formatErrors(e.response.data.errors)
      }
      if (e.response?.status === 403) {
        router.push('/unauthorized')
      }
    }
  }

  const destroy = async (id: any) => {
    resetErrors()

    try {
      await api.delete(`/expenses/${id}`)
    } catch (e: any) {
      if (e.response?.status === 403) {
        router.push('/unauthorized')
      }
    }
  }

  const resetErrors = () => {
    errors.value = {
      value: '',
      description: '',
      date: ''
    }
  }

  return {
    errors,
    index,
    store,
    destroy,
    show,
    update,
    expenses
  }
}

export default useExpense
