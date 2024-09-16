<template>
  <title>Concours | Editer | Admin | The Tip Top</title>
  <h1>{{ text }} un concours</h1>
  <router-link :to="{ name: 'adminconcours' }" class="cFont-1 hover-2">Retour</router-link>
  <FormVue :datas="lottery" :formFields="formField" :submitText="text" @submit="handleSubmit" />
</template>

<script>
import FormVue from '@components/FormVue'
import {Lottery} from '@js/api/Concours'
import auth from '@js/api/Authentification'
export default {
  name: "AdminEditConcours",
  components: {
        FormVue
  },
  data() {
    return {
      lottery: new Lottery(),
      formField : [],
      id : this.$route.params.id || null,
      text : this.$route.params.id ? "Editer" : "Créer"
    }
  },
  async mounted(){
    if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
    } 
    this.formField = this.lottery.getFormFields()
    if (this.id){
      await this.lottery.get(this.id)
      console.log(this.lottery)
    }
  },
    methods:{
      async handleSubmit() {
        const msg = this.id ? await this.lottery.update() : await this.lottery.create()
        this.$router.push({ name: 'adminconcours' });
      }
    }
};
</script>
