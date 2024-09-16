<template>
  <title>Inscription | The Tip Top</title>
    <h1 class="h3 mb-3 font-weight-normal">Créer un compte</h1>
    <FormVue :datas="user" :formFields="formField" submitText="Créer" @submit="handleSubmit" />
    <br/>
    <router-link :to="{ name: 'login', query: {redirectTo : $route.query.redirectTo, numero : $route.query.numero}  }" class="cFont-1 hover-2">Vous avez déjà un compte ?</router-link>

</template>

  <script>
    import {User} from '@js/api/User';
    import FormVue from '@components/FormVue'
    export default {
      name: "Register",
      components: {
        FormVue
      },
      data(){
        return {
          user: new User(),
          formField : [],
        }
      },
      mounted(){
        this.formField = this.user.getFormFields()
      },
      methods:{
        async handleSubmit() {
          this.user.postalCode = parseInt(this.user.postalCode )
          const msg = await this.user.register()
          if (msg['hydra:description'] !== undefined){
            this.formField.email.error = "Cet email est déja enregisté"
          }else{
            this.user.password = null
            this.$router.push({ name: 'login', query: {redirectTo : this.$route.query.redirectTo, numero : this.$route.query.numero}  });
          }
        }
      }
    }
  </script>