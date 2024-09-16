<template>
  <title>Ticket | Admin | The Tip Top</title>
  <div>
    <h1>Liste des tickets</h1>
    <button v-if="tickets.length < 1500000" class="marge-1" @click="create()">Créer un ticket</button>
    <div class="marge-1">{{tickets.length}} / 1 500 000 tickets</div>

    <table v-if="!isMobile">
      <thead>
        <tr>
          <th>Numero</th>
          <th>Concours</th>
          <th>Lot</th>
          <th>Utilisateur</th>
          <th>Date d'emission</th>
          <th>Date de reclamation</th>
          <th>Statut</th>
          <th></th>
        </tr>
      </thead>
      <tbody v-if="tickets.length > 0">
        <tr v-for="ticket in tickets" :key="ticket.id">
          <td v-if="!ticket.utilisateur">
            <span class="cFont-5 hover-1 click"  @click="showModal(ticket.numero)">
              {{ ticket.numero }}
            </span>
          </td>
          <td v-else>
            {{ ticket.numero }}
          </td>
          <td>
            <router-link class="cFont-5 hover-1" :to="{ name: 'adminconcoursshow', params: { id: ticket.concours.id }, query: { redirectFrom: 'ticket' } }">
              {{ ticket.concours.nom }}
            </router-link>            
          </td>
          <td>
            <router-link v-if="ticket.prize" class="cFont-5 hover-1" :to="{ name: 'adminprizeshow', params: { id: ticket.prize.id }, query: { redirectFrom: 'ticket' } }">
              {{ticket.prize.nom }}
            </router-link>
          </td>
          <td>
            <router-link v-if="ticket.utilisateur" class="cFont-5 hover-1" :to="{ name: 'adminusersshow', params: { id: ticket.utilisateur.id }, query: { redirectFrom: 'ticket' } }">
              {{ticket.utilisateur.email }}
            </router-link>
          </td>
          <td>{{ formatDate(ticket.dateEmission) }}</td>
          <td>{{ ticket.dateReclamation && formatDate(ticket.dateReclamation) }}</td>
          <td>{{ ticket.statutReclamation }}</td>
          <td>
            <span href="" class="cFont-7 hover-1 click" @click="del(ticket.numero)">
              <i  class="fa fa-trash" aria-hidden="true"></i>
            </span>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun lot enregistré</td></tr>
      </tbody>
    </table>
    <table v-else v-for="ticket in tickets" :key="ticket.id" class="noMin">
      <tbody v-if="tickets.length > 0">
        <tr>
          <th>Numero</th>
          <td>{{ ticket.numero }}</td>
        </tr>
        <tr>
          <th>Concours</th>
          <td>
            <router-link class="cFont-5 hover-1" :to="{ name: 'adminconcoursshow', params: { id: ticket.concours.id }, query: { redirectFrom: 'ticket' } }">
              {{ ticket.concours.nom }}
            </router-link>            
          </td>
        </tr>
        <tr>
          <th>Lot</th>
          <td>
            <router-link v-if="ticket.prize" class="cFont-5 hover-1" :to="{ name: 'adminprizeshow', params: { id: ticket.prize.id }, query: { redirectFrom: 'ticket' } }">
              {{ticket.prize.nom }}
            </router-link>
          </td>
        </tr>
        <tr>
          <th>Utilisateur</th>
          <td>
            <router-link v-if="ticket.utilisateur" class="cFont-5 hover-1" :to="{ name: 'adminusersshow', params: { id: ticket.utilisateur.id }, query: { redirectFrom: 'ticket' } }">
              {{ticket.utilisateur.email }}
            </router-link>
          </td>
        </tr>
        <tr>
          <th>Date d'emission</th>
          <td>{{ formatDate(ticket.dateEmission) }}</td>
        </tr>
        <tr>
          <th>Date de reclamation</th>
          <td>{{ ticket.dateReclamation && formatDate(ticket.dateReclamation) }}</td>
        </tr>
        <tr>
          <th>Statut</th>
          <td>{{ ticket.statutReclamation }}</td>
        </tr>     
        <tr>
          <th></th>
          <td>
            <span href="" class="cFont-7 hover-1 click" @click="del(ticket.numero)">
              <i  class="fa fa-trash" aria-hidden="true"></i>
            </span>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun lot enregistré</td></tr>
      </tbody>
    </table>
  </div>
    <Modal :open="isOpen" @close="isOpen = !isOpen">
      <div class="marge-1"><qrcode-vue :value="qrLink" :size="500"/></div>
    </Modal>
</template>

<script>
import {Ticket} from '@js/api/Ticket'
import {Lottery} from '@js/api/Concours'
import auth from '@js/api/Authentification'
import Modal from '@components/Modal'
import { ref } from "vue";
import QrcodeVue from 'qrcode.vue'
export default {
  name: "Ticket",
  components: { Modal, QrcodeVue, },
  data() {
    return {
      lottery: new Lottery(),
      ticket: new Ticket(),
      tickets : [],
      isMobile: false,
      showPopup: false,
      qrLink: ""
    };
  },
  setup() {
    const isOpen = ref(false);

    return { isOpen };
  },
  async mounted(){
    this.detectMobileScreen()
    if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
    } 
    this.tickets = ((await this.ticket.gets())["hydra:member"]).reverse()
    
  },
  methods: {
    detectMobileScreen() {
      this.isMobile = window.innerWidth < 1000 
    },
    del(id) {
      this.ticket.delete(id)
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
    async create(){
      await this.lottery.getCurrent()
      const concours_id = this.lottery.current_concours[0].id
      await this.ticket.create(concours_id)
      this.tickets.unshift(this.ticket)
    },
    showModal(numero){
      this.qrLink = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/login?redirectTo=prize&numero=${numero}`
      console.log(this.qrLink)
      this.isOpen = true
    }
  }
};
</script>
