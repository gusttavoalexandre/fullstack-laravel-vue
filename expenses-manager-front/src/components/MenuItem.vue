<template>
  <q-item
    clickable
    tag="router-link"
    :to="link"
  >
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup lang="ts">

export interface MenuItemProps {
  title: string;
  link: string;
  icon: string;
};

withDefaults(defineProps<MenuItemProps>(), {
  title: '',
  link: '#',
  icon: '',
});
</script>
