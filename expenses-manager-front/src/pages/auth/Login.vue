<template>
  <q-page class="row items-center justify-evenly">
    <q-card class="q-pa-md" style="width: 400px">
      <q-card-section>
        <div class="text-h6">Login</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit.prevent="onSubmit" class="q-gutter-md">
          <q-input filled v-model="email" type="email" label="E-mail" />
          <q-input filled v-model="password" type="password" label="Senha" />
          <div>
            <q-btn label="Entrar" type="submit" color="primary" class="full-width" />
          </div>
        </q-form>
        <div class="q-mt-md">
          <span>Não possui uma conta ?
            <router-link
          clickable
          to="/register"
          > Registre-se agora</router-link>
          </span>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
defineOptions({
  name: 'LoginPage'
});

const email = ref('');
const password = ref('');

const onSubmit = () => {
  console.log('Login attempt with:', email.value, password.value);
};

</script>
