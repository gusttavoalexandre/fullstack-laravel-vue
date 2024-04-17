<template>
  <q-page class="row items-center justify-evenly">
    <q-card
      v-for="item in currentStatus"
      :key="item?.label"
      v-bind="item"
      class="my-card text-white"
      style="background: radial-gradient(circle, #35a2ff 0%, #014a88 100%)"
    >
      <q-card-section>
        <div class="text-h6">{{ item.label }}</div>
      </q-card-section>

      <q-card-section class="q-pt-none">
        {{ item.value }}
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
defineOptions({
  name: 'HomePage'
});
import useExpense from '../composables/useExpense'
const { status } = useExpense()
import { onMounted, ref, type Ref } from 'vue'

type ExpenseStatus = {
  label: string
  value: string
}

const currentStatus: Ref<Array<ExpenseStatus>> = ref([])

onMounted(async () => {
  currentStatus.value = await status()
})
</script>
