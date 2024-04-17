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

const useExpense = () => {
  const errors = ref({})
  const router = useRouter()
  const expenses: Ref<Array<Expense>> = ref([])

  const index = async () => {
    try {
      const response = await api.get('/expenses')
      expenses.value = response.data.data
    } catch (e: any) {
      console.log('Internal error', e)
    }
  }

  const show = async (id: number): Promise<Expense | undefined> => {
    try {
      const response = await api.get(`/expenses/${id}`)
      return response.data.data
    } catch (e: any) {
      if (e.response?.status === 403) {
        router.push({ name: 'not_found' })
      }
    }
  }

  const store = async (params: ExpenseParams) => {
    errors.value = {}

    try {
      await api.post('/expenses', params)

      router.push({ name: 'expense.index' })
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
        router.push({ name: 'not_found' })
      }
    }
  }

  const destroy = async (expense: any) => {
    errors.value = {}

    try {
      await api.delete(`/expenses/${expense.id}`)
    } catch (e: any) {
      if (e.response?.status === 403) {
        router.push({ name: 'not_found' })
      }
    }
  }

  const status = async () => {
    try {
      const response = await api.get('/status/expense')
      return response.data
    } catch (e: any) {
      console.log('Internal error', e)
    }
  }

  return {
    errors,
    index,
    store,
    destroy,
    show,
    update,
    status,
    expenses
  }
}

export default useExpense
