<template>
  <title>Connexion | The Tip Top</title>
  <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
  <form @submit.prevent="login">
    <div>
      <input v-model="email" placeholder="Email" type="email" name="email" id="inputEmail" class="form-control" autocomplete="email" required autofocus>
      <label for="inputEmail">Email</label>
    </div>
    <div>
      <input v-model="password" placeholder="Password" type="password" name="password" id="inputPassword" class="form-control" autocomplete="current-password" required>
      <label for="inputPassword">Mot de passe</label>
    </div>
    <button type="submit">Se connecter</button>
  </form>
  <br/>
  <router-link :to="{ name: 'register', query: {redirectTo : $route.query.redirectTo, numero : $route.query.numero} }" class="cFont-1 hover-2">Vous n'avez pas encore de compte ?</router-link>
</template>

<script>
  import auth from '@js/api/Authentification'
  export default {
    name: "Login",
    data(){
      return {
        email: '',
        password: '',
      }
    },
    mounted() {

      if(auth.getUser()){
        this.$router.push({ name: this.$route.query.redirectTo|| 'myaccount', query : {numero : this.$route.query.numero} });
      }
    },
    methods:{
      async login(){
        try {          
          
          if (await auth.login({ email: this.email, password: this.password })){
            window.location.reload()
          }else{
            alert("le mail ou le mot de passe est erroné")
          }
        } catch (error) {
          console.error('Erreur lors de la connexion :', error);
        }
      }
    }
  }
</script>