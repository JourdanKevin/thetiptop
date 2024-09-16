<template>
  <title>Concours | Admin | The Tip Top</title>
  <div>
    <h1>Liste des concours</h1>

    <div class="marge-2">
      <router-link :to="{ name: 'adminconcourscreate'}" class="btn">Nouveau concours</router-link>
    </div>

    <table v-if="!isMobile">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Date début</th>
          <th>Date fin</th>
          <th>Date tirage</th>
          <th>Tirage/Gagnant</th>
          <th></th>
        </tr>
      </thead>
      <tbody v-if="lotteries.length > 0">
        <tr v-for="lottery in lotteries" :key="lottery.id">
          <td>{{ lottery.nom }}</td>
          <td>{{ formatDate(lottery.dateDebut) }}</td>
          <td>{{ formatDate(lottery.dateFin) }}</td>
          <td>{{ formatDate(lottery.dateTirage) }}</td>
          <td>
            <router-link v-if="lottery.gagnant" class="cFont-5 hover-1" :to="{ name: 'adminusersshow', params: { id: lottery.gagnant.id }, query: { redirectFrom: 'adminconcours' } }">
              {{lottery.gagnant.email }}
            </router-link>
            <button v-else class="tirage"  @click="getWinner(lottery.id)">Tirage</button> 
          </td>
          <td>
            <span v-if="lottery.tickets.length === 0" href="" class="cFont-7 hover-1 click" @click="del(lottery.id)">
              <i  class="fa fa-trash" aria-hidden="true"></i>
            </span>
            <router-link :to="{ name: 'adminconcoursedit', params: { id: lottery.id } }">
              <i class="fas fa-edit" aria-hidden="true"></i>
            </router-link>
            <router-link :to="{ name: 'adminconcoursshow', params: { id: lottery.id } }">
              <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun concours enregistré</td></tr>
      </tbody>
    </table>

    <table v-else v-for="lottery in lotteries" :key="lottery.id">
      <tbody v-if="lotteries.length > 0">
        <tr>
          <th>Nom</th>
          <td>{{ lottery.nom }}</td>
        </tr>
        <tr>
          <th>Date début</th>
          <td>{{ formatDate(lottery.dateDebut) }}</td>
        </tr>
        <tr>
          <th>Date fin</th>
          <td>{{ formatDate(lottery.dateFin) }}</td>
        </tr>
        <tr>
          <th>Date tirage</th>
          <td>{{ formatDate(lottery.dateTirage) }}</td>
        </tr>
        <tr>
          <th>Tirage/Gagnant</th>
          <td>
            <router-link v-if="lottery.gagnant" class="cFont-5 hover-1" :to="{ name: 'adminusersshow', params: { id: lottery.gagnant.id }, query: { redirectFrom: 'adminconcours' } }">
              {{lottery.gagnant.email }}
            </router-link>
            <button v-else class="tirage"  @click="getWinner(lottery.id)">Tirage</button> 
          </td>
        </tr>
        <tr>
          <th></th>
          <td>
            <span v-if="lottery.tickets.length === 0" href="" class="cFont-7 hover-1 click" @click="del(lottery.id)">
              <i  class="fa fa-trash" aria-hidden="true"></i>
            </span>
            <router-link :to="{ name: 'adminconcoursedit', params: { id: lottery.id } }">
              <i class="fas fa-edit" aria-hidden="true"></i>
            </router-link>
            <router-link :to="{ name: 'adminconcoursshow', params: { id: lottery.id } }">
              <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun concours enregistré</td></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import {Lottery} from '@js/api/Concours'
export default {
  name: "AdminConcours",
  data() {
    return {
      lottery: new Lottery(),
      lotteries : [],
      isMobile : false
    };
  },
  async mounted(){
    this.detectMobileScreen()
    this.lotteries = (await this.lottery.gets())["hydra:member"]
    
  },
  methods: {
    detectMobileScreen() {
      this.isMobile = window.innerWidth < 1000 
    },
    del(id) {
      this.lottery.delete(id)
      window.location.reload()
    },
    formatDate(dateString) {
        var dateObject = new Date(dateString);
        var day = dateObject.getDate();
        var month = dateObject.getMonth() + 1;
        var year = dateObject.getFullYear();

        var formattedDay = (day < 10 ? '0' : '') + day;
        var formattedMonth = (month < 10 ? '0' : '') + month;

        var formattedDate = formattedDay + '/' + formattedMonth + '/' + year;
        return formattedDate;
    },
    getWinner(id){
      this.lottery.getWinner(id)
      window.location.reload()
    }
  }
};
</script>