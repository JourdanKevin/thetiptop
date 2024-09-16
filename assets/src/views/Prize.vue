<template>
  <title>Tirage d'un lot | The Tip Top</title>
  <h1>Inscrivez le numéro obtenu sur votre ticket</h1>
    <form @submit.prevent="getPrize()">
      <div>
        <input v-model="numero" placeholder="numero" type="text" name="numero">
        <label for="inputEmail">Numéro</label>
      </div>
        <button type="submit">Obtenir son lot</button>
    </form>
    <p v-if="error">{{ error }}</p>
    <div v-if="prize.nom" class="prize">
      {{message}} : {{prize.nom}}
      <span v-if="prize.valeur">d'une valeur de {{ prize.valeur }}€</span>
      <div><img :src="'/images/' + lots[prize.valeur || prize.nom]" alt="illustration du lot"></div>
    </div>
</template>

<script>
  import auth from '@js/api/Authentification'
  import { Prize } from '@js/api/Prize'
  import { Ticket } from '@js/api/Ticket'
  export default {
    name: "Prize",
    data(){
      return {
        prize : new Prize(),
        user : auth.user,
        ticket : new Ticket(),
        numero : this.$route.query.numero || null,
        lots : {
            "Infuseur à thé" : "infuseur_a_the.webp",
            "Boite (100g) thé détox / d’infusion" : "boite_infusion.webp",
            "Boite (100g) thé signature" : "boite_the_signature.webp",
            "39" : "coffret_39.webp",
            "69" : "coffret_69.webp",
        },
        message : "Vous avez gagné",
        error: null
      }
    },
    mounted(){
      if (!auth.getUser()){
        this.$router.push({ name: 'login', query: { redirectTo: 'prize' } });
      }  
    },
    methods:{
      async getPrize(){
        const prize = await this.ticket.getPrize(this.numero)
        this.error = null
        if (prize){
          if (prize.user == auth.user.id){
            this.prize.setProperties(prize.prize)
            this.message = "Ce numéro vous à déjà fait remporté"
          }else{
            this.error = "Ce numéro à déjà était récuperer par un autre utilisateur !"
          }
        }else{
          await this.prize.getRand()
          this.ticket.statutReclamation = "Obtenu"
          this.ticket.dateReclamation = new Date()
          this.ticket.utilisateur = `/api/admin/user/${this.user.id}`
          this.ticket.prize = `/api/prize/${this.prize.id}`
          this.ticket.id = this.numero
          this.ticket.update()
          this.prize.setProperties(this.ticket.prize)
      }
    }
    
  }
}
</script>