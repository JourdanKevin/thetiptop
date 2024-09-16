<template>
    <Cookie/>
    <header>
        <nav>
            <router-link :to="{ name: 'home' }" class="logo">
                <img class="logo" src="/images/LogoVersion1.webp" alt="logo site web">
            </router-link>
            <button class="hamburger" aria-label="Menu" @click="toggleMenu">&#9776;</button>
            <div :class="{ 'open nav-links': isOpen }">
                <router-link @click="closeMenu" v-if="userRole !== 'ROLE_ADMIN'" :to="{ name: 'home' }">Accueil</router-link>
                <router-link @click="closeMenu" v-if="userRole !== 'ROLE_ADMIN'"  :to="{ name: 'about' }">À propos</router-link>
                <router-link @click="closeMenu" v-if="userRole !== 'ROLE_ADMIN'"  :to="{ name: 'prize' }">Concours</router-link>
                <router-link @click="closeMenu" v-if="userRole !== 'ROLE_ADMIN'" :to="{ name: 'faq' }">FAQ</router-link>
                <router-link @click="closeMenu" v-if="userRole === 'ROLE_USER'" :to="{ name: 'myprize' }">Mes lots</router-link>                
                <router-link @click="closeMenu" v-if="userRole === 'ROLE_ADMIN'" :to="{ name: 'adminusers' }">Utilisateurs</router-link>
                <router-link @click="closeMenu" v-if="userRole === 'ROLE_ADMIN'" :to="{ name: 'adminconcours' }">Concours</router-link>
                <router-link @click="closeMenu" v-if="userRole === 'ROLE_ADMIN'" :to="{ name: 'adminprize' }">Lots</router-link>
                <router-link @click="closeMenu" v-if="userRole === 'ROLE_ADMIN'" :to="{ name: 'ticket' }">Ticket</router-link>
                <router-link @click="closeMenu" v-if="isAuthenticated" :to="{ name: 'myaccount' }">Mon compte</router-link>
                <router-link @click="closeMenu" v-if="!isAuthenticated" :to="{ name: 'login' }">Connexion</router-link>
                <a v-if="isAuthenticated" href=""  @click="logout" title="Se déconnecter" class="link-disconnect"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
            </div>
        </nav>
    </header>
</template>

<script>
    import auth from '@js/api/Authentification'
    import Cookie from '@components/Cookie'
    export default {
        name: "Header",
        components: {
            Cookie
        },
        data() {
            return {
                isAuthenticated: false,
                userRole: '',
                isOpen: false
            };
        },
        mounted() {
            this.getUserRole();
        },
        methods: {
            async getUserRole() {
                if(auth.getUser()){
                    this.isAuthenticated = true
                    this.userRole = auth.user.roles[0]
                }                
            },
            logout() {
                auth.logout()
                this.isAuthenticated = false;
                this.userRole = '';
                this.$router.push({ name: 'home' });
            },
            toggleMenu() {
                this.isOpen = !this.isOpen; // Inversion de l'état du menu lors du clic sur l'icône hamburger
            },
            closeMenu() {
                this.isOpen = false; // Fermer le menu lorsque vous cliquez sur un lien
            }
        }
    }
</script>
