<template>
  <title>Mes lots | The Tip Top</title>
    <h1>Mes lots remportés</h1>
    <ul v-if="Object.keys(prizes).length > 0">
      <li v-for="(count, prize) in prizes" :key="prize">
        {{ prize }} : {{ count }} fois
      </li>
    </ul>
    <p v-else>{{message}}</p>
</template>

<script>
import auth from '@js/api/Authentification';
export default {
  name: "MyPrize",
  data() {
    return {
      prizes: {},
      message : null
    };
  },
  async mounted(){
        if (!auth.getUser()){
          this.$router.push({ name: 'login' });
        } 
        await auth.user.get()
        auth.setUser(auth.user)
        auth.user.tickets.forEach(ticket => {
          if(this.prizes[ticket.prize.nom] === undefined){
            this.prizes[ticket.prize.nom] = 0
          }
          this.prizes[ticket.prize.nom] += 1
        });
        if (Object.keys(this.prizes).length < 1){
          this.message = "Vous n'avez remporté aucun lot pour le moment."
        }
      },
      
};
</script>