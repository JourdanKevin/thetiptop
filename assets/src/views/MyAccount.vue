<template>
  <title>Mon compte | The Tip Top</title>
    <h1>Gestion de mon compte</h1>
    <h2>Ravi de vous revoir {{user.name}} {{user.surname}}</h2>
    <router-link :to="{ name: 'myaccountedit' }" class="btn">éditer</router-link>
    <Card :data="user" :excludedKeys="['id', 'password','tickets','concoursGagnes','address_2','createdAt','updatedAt','roles']" />
  </template>
  
  <script>
    import auth from '@js/api/Authentification';
    import Card from '@components/Card';
    export default {
      name: "MyAccount",
      components: {
        Card
      },
      data() {
            return {
                user : auth.user
            };
        },
        mounted() {
            this.getUserRole();
        },
        methods: {
            async getUserRole() {
              if (!auth.getUser()){
                this.$router.push({ name: 'login' });
              }          
            },
        }
    }
    
  </script>