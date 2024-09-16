import fetchService from '@js/api/FetchService'
import { User } from '@js/api/User.js'

class Authentification {
    constructor() {
        this.user = new User()
    }

    async login(loginData) {
        try {
            const data = await fetchService.post('token', loginData);
            console.log(data)
            if (data['code'] !== undefined){
                return false
            }
            fetchService.token = data.token;          
            await this.user.get()
            this.setUser(this.user)
            return true
        } catch (error) {
            console.error(error);
            throw error;
        }
    }
    setUser(user){
        sessionStorage.setItem('user', JSON.stringify(user));
    }
    getUser(){
        const user = sessionStorage.getItem('user')
        if (user){
            this.user.setProperties(JSON.parse(user))
            return true
        }return false
    }

    logout(){
        this.user = null
        fetchService.deleteToken()
        sessionStorage.removeItem('user');
    }
    isAuthenticated() {
        return !!fetchService.token
    }
}

const auth = new Authentification();

export default auth;