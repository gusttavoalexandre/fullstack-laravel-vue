<template>
  <q-page class="row items-center justify-evenly">
    <q-card class="q-pa-md" style="width: 400px">
      <q-card-section>
        <div class="text-h6">💰 Registrar nova despesa</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit.prevent="onSubmit" class="q-gutter-md">
          <q-input filled v-model="form.description" type="text" label="Descrição" :error="errors.description?.length > 0" :error-message="errors.description"/>
          <q-input mask="##/##/####" filled v-model="form.date" label="Data" :error="errors.date?.length > 0" :error-message="errors.date">
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-date v-model="form.date" mask="DD/MM/YYYY">
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <q-input
            type='number' step='0.01' value='0.00' placeholder='0.00'
            filled
            v-model="form.value"
            label="Valor (R$)"
            :error="errors.value?.length > 0" :error-message="errors.value"
          />
          <div>
            <q-btn label="Registrar despesa" type="submit" color="primary" class="full-width" />
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
defineOptions({
  name: 'ExpenseCreate'
});
import useExpense from '../../composables/useExpense'
const { store, errors } = useExpense()
import { reactive } from 'vue'

const form = reactive({
  description: '',
  date: '',
  value: ''
})

const onSubmit = async () => {
  await store(form)
}

</script>
