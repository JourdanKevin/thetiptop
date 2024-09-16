<template>
   <div v-if="show" class="cookie">
        <div>
            <p>En continuant à naviguer, vous acceptez notre utilisation des cookies.</p>
            <div>
                <button id="refuse-cookie" aria-label="Refuser les cookies" @click="refuse">Refuser</button>
                <button id="accept-cookie" aria-label="Accepter les cookies" @click="accept">Accepter</button>
                <router-link title="Mentions légales - Informations légales" aria-label="Mentions légales - Informations légales" :to="{ name: 'mentionlegal' }">Mentions légales</router-link>
            </div>            
        </div>
    </div> 
</template>
  

  <script>
    export default {
      name: "Cookie",
      data(){
        return {
            show : false
        }
      },
      mounted() {
        this.show = !(localStorage.getItem('cookiesAccepted') === 'true');
      },
      methods:{
        accept(){
            localStorage.setItem('cookiesAccepted', 'true');
            this.show = false
        },
        refuse(){
            localStorage.setItem('cookiesAccepted', 'false');
            this.show = false
        }
      }
    }
  </script>