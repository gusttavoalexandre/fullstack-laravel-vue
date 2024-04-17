<template>
  <div class="q-pa-md">
    <q-table
      title="Despesas"
      :rows="expenses"
      :columns="columns"
      row-key="name"
    >
      <template v-slot:top-right>
        <q-btn
          color="primary"
          icon-right="add_circle"
          label="Nova despesa"
          no-caps
          @click="goToCreate"
        />
      </template>
      <template v-slot:body-cell-editAction="props">
        <q-td :props="props">
          <q-btn flat icon="edit" @click="goToEdit(props.row.id)" />
        </q-td>
      </template>
      <template v-slot:body-cell-deleteAction="props">
        <q-td :props="props">
          <q-btn flat icon="delete" @click="deleteItem(props.row.id)" />
        </q-td>
      </template>
    </q-table>
  </div>
</template>
<script setup lang="ts">
defineOptions({
  name: 'ExpenseIndex'
});
import { useRouter } from 'vue-router';

import useExpense from '../../composables/useExpense'
const { index, destroy, expenses } = useExpense()
import { onMounted } from 'vue'
import { QTableColumn } from 'quasar'

const router = useRouter();

const columns: QTableColumn[] = [
  {
    name: 'description',
    label: 'Descricão',
    field: 'description',
    align: 'left',
  },
  {
    name: 'date',
    label: 'Data',
    field: 'formatted_date',
    align: 'left',
  },
  {
    name: 'value',
    label: 'Valor',
    field: 'formatted_value',
    align: 'left',
  },
  {
    name: 'editAction',
    label: '',
    field: 'id',
    align: 'center',
    sortable: false
  },
  {
    name: 'deleteAction',
    label: '',
    field: 'id',
    align: 'center',
    sortable: false
  },
]
const goToCreate = () => {
  router.push('/expenses/create');
}
const goToEdit = (id: number) => {
  router.push({ name: 'expenses/edit', params: { id } });
}
const deleteItem = async (id: number) => {
  await destroy(id)
  await index()
}

onMounted(async () => {
  await index()
})
</script>
