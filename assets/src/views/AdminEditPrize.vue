<template>
<title>Lot | Editer | Admin | The Tip Top</title>
  <h1>{{ text }} un lot</h1>
  <router-link :to="{ name: 'adminprize' }" class="cFont-1 hover-2">Retour</router-link>
  <FormVue :datas="prize" :formFields="formField" :submitText="text" @submit="handleSubmit" />
</template>

<script>
import FormVue from '@components/FormVue'
import {Prize} from '@js/api/Prize'
import auth from '@js/api/Authentification'
export default {
  name: "AdminEditPrize",
  components: {
        FormVue
  },
  data() {
    return {
      prize: new Prize(),
      formField : [],
      id : this.$route.params.id || null,
      text : this.$route.params.id ? "Editer" : "Créer"
    }
  },
  mounted(){
    if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
    } 
    this.formField = this.prize.getFormFields()
    if (this.id){
      this.prize.get(this.id)
    }
  },
    methods:{
      async handleSubmit() {
        const msg = this.id ? await this.prize.update() : await this.prize.create()
        this.$router.push({ name: 'adminprize' });
      }
    }
};
</script>
