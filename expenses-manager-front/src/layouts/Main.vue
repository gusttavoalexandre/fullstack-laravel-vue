<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          <LogoType/>
        </q-toolbar-title>

      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          Menu
        </q-item-label>

        <MenuItem
          v-for="item in navigator"
          :key="item.title"
          v-bind="item"
        />
        <q-item
          clickable
          tag="a"
          @click="logout"
        >
          <q-item-section
            avatar
          >
            <q-icon name="logout" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Sair</q-item-label>
          </q-item-section>
        </q-item>

      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import MenuItem, { MenuItemProps } from 'components/MenuItem.vue';
import LogoType from 'components/LogoType.vue';
import useAuth from '../composables/useAuth'

defineOptions({
  name: 'MainLayout'
});


const navigator: MenuItemProps[] = [
  { link: '/', title: 'Dashboard', icon: 'dashboard' },
  { link: '/expenses', title: 'Despesas', icon: 'credit_card' }
]
const { logout } = useAuth()
const leftDrawerOpen = ref(false);

function toggleLeftDrawer () {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
