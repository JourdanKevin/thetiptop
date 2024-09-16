<template>
  <title>Mon compte | Editer | The Tip Top</title>
    <h1>Gestion de mon compte</h1>
    <h2>Modifier mes informations</h2>
    <FormVue :datas="user" :formFields="formField" submitText="Modifier" @submit="handleSubmit" />
    <br/>
    <router-link :to="{ name: 'myaccount' }" class="cFont-1 hover-2">Retour</router-link>

</template>

  <script>
    import auth from '@js/api/Authentification';
    import FormVue from '@components/FormVue'
    export default {
      name: "MyAccountEdit",
      components: {
        FormVue
      },
      data(){
        return {
          user: auth.user,
          formField : [],
        }
      },
      mounted(){
        if (!auth.getUser()){
            this.$router.push({ name: 'login' });
        } 
        this.formField = this.user.getFormFields()
        this.formField.password.required = false
        // console.log(auth.fetchService.token)
      },
      methods:{
        async handleSubmit() {
          const msg = await this.user.update()
          if (msg['hydra:description'] !== undefined && msg['hydra:description'].includes("Duplicate entry")){
            this.formField.email.error = "Cet email est déja enregisté"
          }else{
            auth.setUser(msg)
            this.user.password = null
            this.$router.push({ name: 'myaccount' });
          }
        }
      }
    }
  </script>