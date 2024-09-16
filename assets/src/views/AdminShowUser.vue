<template>
  <title>Utilisateur | Afficher | Admin | The Tip Top</title>
    <h1>Concours</h1>
    <router-link :to="{ name: $route.query.redirectFrom || 'adminusers' }" class="cFont-1 hover-2">Retour</router-link>
    <Card :data="user" :excludedKeys="['id','tickets','address_2','concoursGagnes','password','@context','@id','@type']" />
    <h2>Lots remportés</h2>
    <ul v-if="Object.keys(prizes).length > 0">
      <li v-for="(count, prize) in prizes" :key="prize">
        {{ prize }} : {{ count }} fois
      </li>
    </ul>
    <p v-else>Aucun lot remporté</p>
  </template>
  
  <script>
  import Card from '@components/Card'
  import {User} from '@js/api/User'
  import auth from '@js/api/Authentification'
  export default {
    name: "AdminShowUser",
    components: {
          Card
    },
    data() {
      return {
        user: new User(),
        prizes: {}
      }
    },
    async mounted(){
      if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
      } 
      await this.user.getById(this.$route.params.id)
      console.log(this.user)
      this.user.tickets.forEach(ticket => {
          if(this.prizes[ticket.prize.nom] === undefined){
            this.prizes[ticket.prize.nom] = 0
          }
          this.prizes[ticket.prize.nom] += 1
        });
    }
  };
  </script>
  