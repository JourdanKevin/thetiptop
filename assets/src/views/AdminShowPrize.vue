<template>
  <title>Lot | Afficher | Admin | The Tip Top</title>
    <h1>Lot</h1>
    <router-link :to="{ name: $route.query.redirectFrom || 'adminprize' }" class="cFont-1 hover-2">Retour</router-link>
    <Card :data="prize" :excludedKeys="['id','tickets','@context','@id','@type']" />
  </template>
  
  <script>
  import Card from '@components/Card'
  import {Prize} from '@js/api/Prize'
  import auth from '@js/api/Authentification'
  export default {
    name: "AdminShowPrize",
    components: {
          Card
    },
    data() {
      return {
        prize: new Prize(),
      }
    },
    mounted(){
      if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
      } 
      this.prize.get(this.$route.params.id)
      console.log(this.prize)
    }
  };
  </script>
  