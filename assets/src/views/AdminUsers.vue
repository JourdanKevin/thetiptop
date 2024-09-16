<template>
  <title>Utilisateurs | Admin | The Tip Top</title>
  <div>
    <h1>Liste des utilisateurs</h1>
    <table v-if="!isMobile">
      <thead>
        <tr>
          <th>Nom / Prénom</th>
          <th>Email</th>
          <th>Roles</th>
          <th>Nombre de lot gagné</th>
          <th></th>
        </tr>
      </thead>
      <tbody v-if="users.length > 0">
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.roles.join(", ") }}</td>
          <td>{{ user.tickets.length }}</td>
          <td>
            <router-link :to="{ name: 'adminusersshow', params: { id: user.id } }">
              <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun utilisateur enregistré</td></tr>
      </tbody>
    </table>

    <table v-else v-for="user in users" :key="user.id">
      <tbody v-if="users.length > 0">
        <tr>
          <th>Nom / Prénom</th>
          <td>{{ user.name + ' ' + user.surname }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ user.email }}</td>
        </tr>
        <tr>
          <th>Roles</th>
          <td>{{ user.roles.join(", ") }}</td>
        </tr>
        <tr>
          <th>Nombre de lot gagné</th>
          <td>{{ user.tickets.length }}</td>
        </tr>
        <tr>
          <th></th>
          <td>
            <router-link :to="{ name: 'adminusersshow', params: { id: user.id } }">
              <i class="fa-solid fa-eye" aria-hidden="true"></i>
            </router-link>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr><td colspan="5">Aucun utilisateur enregistré</td></tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import {User} from '@js/api/User'
import auth from '@js/api/Authentification'
export default {
  name: "AdminConcours",
  data() {
    return {
      user: new User(),
      users : [],
      isMobile : false
    };
  },
  async mounted(){
    this.detectMobileScreen()
    if (!auth.getUser() || (auth.user.roles[0] !== "ROLE_ADMIN")){
          this.$router.push({ name: 'home' });
    } 
    this.users = (await this.user.gets())["hydra:member"]
  },
  methods: {
    detectMobileScreen() {
      this.isMobile = window.innerWidth < 1000 
    }
  }
};
</script>