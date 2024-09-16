class FetchService {
    constructor() {
      this.baseURL = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/api`;
    }
    get token(){
      return sessionStorage.getItem('token')
    }
    set token(token){
      sessionStorage.setItem('token', token);
    }
    deleteToken(){
      sessionStorage.removeItem('token');
    }
  
    async fetchData(endpoint, method = 'GET', body = null) {
      const headers = {
        'Content-Type': 'application/json',
      };
      if (this.token) {
        headers['Authorization'] = `Bearer ${this.token}`;
      }
  
      const requestOptions = {
        method: method,
        headers: headers,
      };
  
      if (body) {
        requestOptions.body = JSON.stringify(body);
      }
  
      try {
        const response = await fetch(`${this.baseURL}/${endpoint}`, requestOptions);
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        throw error;
      }
    }
  
    async get(endpoint) {
      return this.fetchData(endpoint, 'GET');
    }
  
    async post(endpoint, data) {
      console.log(data)
      return this.fetchData(endpoint, 'POST', data);
    }
  
    async put(endpoint, data) {
      return this.fetchData(endpoint, 'PUT', data);
    }
  
    async delete(endpoint) {
      return this.fetchData(endpoint, 'DELETE');
    }
  }

const fetchService = new FetchService();

export default fetchService;