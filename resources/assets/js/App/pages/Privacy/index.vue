<template>
  <v-container fluid>
    <p>
      <a @click.prevent="$router.push({name: 'Private'})">Политика конфиденциальности</a><br/>
      <a @click.prevent="$router.push({name: 'Services'})">Условия предоставления услуг</a><br/>
      <a @click.prevent="$router.push({name: 'Conditions'})">Условия оплаты</a><br/>
    </p>
  </v-container>
</template>