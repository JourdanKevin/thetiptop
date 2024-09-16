import fetchService from '@js/api/FetchService'


export class User {
    constructor(user = {}) {
        this.id = null;
        this.email = null;
        this.password = null;
        this.roles = null;
        this.name = null;
        this.surname = null;
        this.birthDate = null;
        this.address = null;
        this.postalCode = null;
        this.city = null;
        this.country = null;
        this.createdAt = null;
        this.updatedAt = null;

        this.tickets = null;
        this.concoursGagnes = null;
        
        this.setProperties(user);
    }

    setProperties(properties) {
        properties.password = null
        delete properties.address2
        Object.assign(this, properties);
    }

    getFormFields() {
        return {
            email: { label: 'Email', type: 'email', required : true },
            password: { label: 'Mot de passe', type: 'password', required : true, pattern: '(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}', title : 'Le mot de passe doit contenir au moins un chiffre, une lettre majuscule et une lettre minuscule, et avoir au moins 8 caractères ou plus.', confirm : 'Confirmation du mot de passe' },
            name: { label: 'Nom', type: 'text', required : true },
            surname: { label: 'Prénom', type: 'text', required : true },
            birthDate: { label: 'Date de naissance', type: 'date' },
            address: { label: 'Adresse', type: 'text' },
            postalCode: { label: 'Code postal', type: 'number' },
            city: { label: 'Ville', type: 'text' },
            country: { label: 'Pays', type: 'text' },
        };
    }
    filteredDatas(){
        const filtered = {};
        Object.keys(this.getFormFields()).forEach(key => {
            if (this[key] !== undefined) {
                filtered[key] = this[key];
            }
        });
        return filtered
    }

    async get(){
        this.setProperties(await fetchService.get('account'));
    }

    async gets() {
      return await fetchService.get('admin/user');  
    }

    async getById(id = null){
        this.setProperties(await fetchService.get(`admin/user/${id || this.is}`));
    }
    async register() {
        const datas = await fetchService.post(`register`, this.filteredDatas())
        this.setProperties(datas);
        return datas
    }
    async update(){
        const filtered = this.filteredDatas()
        if (!filtered.password){
            delete filtered.password
        }
        console.log(filtered)
        const datas = await fetchService.put('account',filtered)
        this.setProperties(datas);
        return datas
    }
    async updateById(){
        this.setProperties(await fetchService.put(`admin/user/${id}`,this.filteredDatas()));
    }
    async delete(id){
        this.setProperties(await fetchService.delete(`admin/user/${id}`));
    }
}
