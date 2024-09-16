import fetchService from '@js/api/FetchService'

export class Prize{
    constructor(prize = {}){
        this.id = null;
        this.nom = null;
        this.description = null;
        this.probability = null;
        this.valeur = null;

        this.tickets = null;

        this.setProperties(prize)

    }
    setProperties(properties) {
        Object.assign(this, properties);
    }

    getFormFields() {
        return {
            nom: { label: 'Nom', type: 'text', required : true },
            description: { label: 'Description', type: 'textarea' },
            probability: { label: 'Probabilité', type: 'number', required : true },
            valeur: { label: 'Valeur', type: 'number' },
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

    async get(id = null){
        this.setProperties(await fetchService.get(`prize/${id || this.id}`));
    }
    async gets(){
        return await fetchService.get(`prize`);
    }

    async getRand(){
        this.setProperties(await fetchService.get(`random/prize`));
    }
    async create(){
        this.setProperties(await fetchService.post(`admin/prize`,this.filteredDatas()));
    }
    async update(){
        this.setProperties(await fetchService.put(`admin/prize/${this.id}`,this.filteredDatas()));

    }
    async delete(id = null){
        this.setProperties(await fetchService.delete(`admin/prize/${id || this.id}`));
    }
}