import fetchService from '@js/api/FetchService'

export class Ticket{
    constructor(ticket = {}){
        this.id = null;
        this.dateEmission = null;
        this.dateReclamation = null;
        this.statutReclamation = null;

        this.prize = null;
        this.utilisateur = null;
        this.concours = null;

        this.setProperties(ticket)

    }
    setProperties(properties) {
        Object.assign(this, properties);
    }

    getFormFields() {
        return {
            dateEmission: { label: 'Date d\'émission', type: 'date' },
            dateReclamation: { label: 'Date de réclamation', type: 'date' },
            statutReclamation: { label: 'Statut de réclamation', type: 'text' },
        };
    }

    async get(){
        this.setProperties(await fetchService.get(`admin/ticket/${this.id}`));
    }
    async gets(){
        return await fetchService.get(`admin/ticket`);
    }
    async create(concours_id){
        this.setProperties(await fetchService.post(`ticket`,{
            concours : `/api/admin/concours/${concours_id}`,
            statutReclamation : 'Enregistré',
            dateEmission : new Date()
        }));
    }
    async update(){
        this.setProperties(await fetchService.put(`ticket/${this.id}`,{
            statutReclamation : this.statutReclamation,
            dateReclamation : this.dateReclamation,
            utilisateur : this.utilisateur,
            prize : this.prize
        }));

    }
    async delete(id){
        this.setProperties(await fetchService.delete(`admin/ticket/${id}`));
    }

    async getPrize(numero){
        return await fetchService.get(`ticket/${numero}/lot`);
    }
}