import fetchService from '@js/api/FetchService'

export class Lottery{
    constructor(lottery = {}){
        this.id = null;
        this.nom = null;
        this.description = null;
        this.dateDebut = null;
        this.dateFin = null;
        this.dateTirage = null;


        this.gagnant = null
        this.tickets = null;

        this.setProperties(lottery)

    }
    setProperties(properties) {
        Object.keys(properties).forEach(key => {
            if (key === 'dateDebut' || key === 'dateFin' || key === 'dateTirage') {
                this[key] = this.parseDate(properties[key]);
            } else {
                this[key] = properties[key];
            }
        });
    }
    parseDate(dateString) {
        const dateObject = new Date(dateString);
        if (!isNaN(dateObject.getTime())) {
            const year = dateObject.getFullYear();
            let month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
            let day = dateObject.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        } else {
            console.error(`La date "${dateString}" n'est pas valide.`);
            return null;
        }
    }

    getFormFields() {
        return {
            nom: { label: 'Nom', type: 'text' },
            description: { label: 'Description', type: 'textarea' },
            dateDebut: { label: 'Date de début', type: 'date' },
            dateFin: { label: 'Date de fin', type: 'date' },
            dateTirage: { label: 'Date de tirage', type: 'date' },
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
        this.setProperties(await fetchService.get(`admin/concours/${id || this.id}`));
    }
    async gets(){
        return await fetchService.get(`concours`);
    }
    async getWinner(id = null){
        this.setProperties(await fetchService.get(`concours/${id || this.id}/winner`));
    }
    async getCurrent(){
        this.setProperties(await fetchService.get(`current/concours`));
    }
    async create(){
        this.setProperties(await fetchService.post(`admin/concours`,this.filteredDatas()));
    }
    async update(){
        this.setProperties(await fetchService.put(`admin/concours/${this.id}`,this.filteredDatas()));

    }
    async delete(id = null){
        this.setProperties(await fetchService.delete(`admin/prize/${id || this.id}`));
    }
}