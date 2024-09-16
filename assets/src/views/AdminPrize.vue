<template>
  <title>Lots | Admin | The Tip Top</title>
  <div>
    <h1>Liste des lots</h1>

    <div class="marge-2">
      <router-link :to="{ name: 'adminprizecreate'}" class="btn">Nouveau lot</router-link>
    </div>

    <table v-if="!isMobile">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Valeur (&euro;)</th>
          <th>Probabilité (%)</th>
          <th>Quantité gagnée</th>
          <th></th>
        </tr>
      </thead>
      <tbody v-if="lots.length > 0">
        <tr v-for="lot in lots" :key="lot.id">
          <td>{{ lot.nom }}</td>
          <td>{{ lot.valeur }}</td>
          <td>{{ lot.probability }}</td>
          <td>{{ lot.tickets.length }}</td>
          <td>
            <span v-if="lot.tickets.length === 0" href="" class="cFont-7 hover-1 click" @click="del(lot.id)">
              <i  class="fa fa-trash" aria-hidden="true"></i>
            </span>
            <router-link :to="{ name: 'adminprizeedit', params: { id: lot.id } }">
              <i class="fas fa-edit" aria-hidden="true"></i>
            </router-link>
            <router-link :to="{ name: 'adminprizeshow', params: { id: lot.id } }">
              <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun lot enregistré</td></tr>
      </tbody>
    </table>

    <table v-else v-for="lot in lots" :key="lot.id">
      <tbody v-if="lots.length > 0">
        <tr>
          <th>Nom</th>
          <td>{{ lot.nom }}</td>
        </tr>
        <tr>
          <th>Valeur (&euro;)</th>
          <td>{{ lot.valeur }}</td>
        </tr>
        <tr>
          <th>Probabilité (%)</th>
          <td>{{ lot.probability }}</td>
        </tr>
        <tr>
          <th>Quantité gagnée</th>
          <td>{{ lot.tickets.length }}</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <span v-if="lot.tickets.length === 0" href="" class="cFont-7 hover-1 click" @click="del(lot.id)">
              <i  class="fa fa-trash" aria-hidden="true"></i>
            </span>
            <router-link :to="{ name: 'adminprizeedit', params: { id: lot.id } }">
              <i class="fas fa-edit" aria-hidden="true"></i>
            </router-link>
            <router-link :to="{ name: 'adminprizeshow', params: { id: lot.id } }">
              <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun lot enregistré</td></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import {Prize} from '@js/api/Prize'
import auth from '@js/api/Authentification'
export default {
  name: "AdminPrize",
  data() {
    return {
      lot: new Prize(),
      lots : [],
      isMobile : false
    };
  },
  async mounted(){
    this.detectMobileScreen()
    if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
    } 
    this.lots = (await this.lot.gets())["hydra:member"]
    
  },
  methods: {
    detectMobileScreen() {
      this.isMobile = window.innerWidth < 1000 
    },
    del(id) {
      this.lot.delete(id)
      window.location.reload()
    }
  }
};
</script>
