<template>
  <title>Concours | Afficher | Admin | The Tip Top</title>
    <h1>Concours</h1>
    <router-link :to="{ name: $route.query.redirectFrom || 'adminconcours' }" class="cFont-1 hover-2">Retour</router-link>
    <Card :data="lottery" :excludedKeys="['id','tickets','@context','@id','@type', 'gagnant']" />
  </template>
  
  <script>
  import Card from '@components/Card'
  import {Lottery} from '@js/api/Concours'
  import auth from '@js/api/Authentification'
  export default {
    name: "AdminShowConcours",
    components: {
          Card
    },
    data() {
      return {
        lottery: new Lottery(),
      }
    },
    mounted(){
      if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
      } 
      this.lottery.get(this.$route.params.id)
    }
  };
  </script>
  