<template>
  <q-page class="row items-center justify-evenly">
    <q-card class="q-pa-md" style="width: 400px">
      <q-card-section>
        <div class="text-h6">Login</div>
      </q-card-section>

      <q-card-section>
      <div class="q-pa-md">
        <q-banner inline-actions class="text-white bg-red text-center" v-if="errors.general?.length > 0">
          {{ errors.general }}
        </q-banner>
      </div>

        <q-form @submit.prevent="onSubmit" class="q-gutter-md">
          <q-input filled v-model="form.name" type="text" label="Nome" :error="errors.name?.length > 0" :error-message="errors.name"/>
          <q-input filled v-model="form.email" type="email" label="E-mail" :error="errors.email?.length > 0" :error-message="errors.email"/>
          <q-input filled v-model="form.password" type="password" label="Senha" :error="errors.password?.length > 0" :error-message="errors.password"/>
          <q-input filled v-model="form.password_confirmation" type="password" label="Confirmar senha" :error="errors.password_confirmation?.length > 0" :error-message="errors.password_confirmation"/>
          <div>
            <q-btn label="Entrar" type="submit" color="primary" class="full-width" />
          </div>
        </q-form>
        <div class="q-mt-md">
          <span>Já possui uma conta ?
            <router-link
          clickable
          to="/login"
          > Entrar agora</router-link>
          </span>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import useAuth from '../../composables/useAuth'
defineOptions({
  name: 'LoginPage'
});
const { register, errors } = useAuth()
import { reactive } from 'vue'

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const onSubmit = async () => {
   await register(form)
};
</script>
