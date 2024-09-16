<template>
    <footer>
        <div>
            <p class="footer_text">© {{ currentYear }}  - Thé Tip Top | Tous droits reservés</p>
            <router-link title="Mentions légales - Informations légales" aria-label="Mentions légales - Informations légales" :to="{ name: 'mentionlegal' }">Mentions légales</router-link>
        </div>
    </footer>
</template>
  
<script>
    export default {
        name: "Footer",
        data() {
            return {
                currentYear: new Date().getFullYear()
            };
         }
    }
</script>