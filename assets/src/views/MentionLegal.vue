<template>
    <title>Mentions légales | The Tip Top</title>
    <h1>Mentions légales</h1>
    <p>Les présentes mentions légales ont pour objet de vous informer sur les conditions d'utilisation du site, les
    informations légales relatives à la société Thé Tip Top et les modalités du jeu-concours organisé par notre
    société. En naviguant sur notre site, vous acceptez sans réserve les dispositions des présentes mentions
    légales.</p>
    <div>
        <h2>Conditions de participation</h2>
        <p>Pour participer au jeu-concours, les participants doivent être âgés de 18 ans ou plus et résider en France
    métropolitaine. Les participants doivent avoir un ticket de caisse ou une facture supérieure à 49€ avec un
    numéro à 10 chiffres permettant une participation.</p>
        <h2>Répartition des gains</h2>
        <ul>
            <li>60% des tickets offrent un infuseur à thé</li>
            <li>20% des tickets offrent une boite de 100g d’un thé détox ou d’infusion</li>
            <li>10% des tickets offrent une boite de 100g d’un thé signature</li>
            <li>6% des tickets offrent un coffret découverte d’une valeur de 39€</li>
            <li>4% des tickets offrent un coffret découverte d’une valeur de 69€</li>
        </ul>
        <h2>Tirage au sort</h2>
        <p>À l’issue du jeu-concours, un tirage au sort sera effectué parmi tous les participants afin de déterminer le
    gagnant d’un an de thé d’une valeur de 360€.</p>
        <h2>Réclamation des lots</h2>
        <p> Les gagnants auront 30 jours à compter de la date de clôture du jeu pour aller sur le site internet afin de
    tester le numéro de leur(s) ticket(s) et réclamer leur lot en magasin ou en ligne.</p>
        <h2>Responsabilité</h2>
        <p>Thé Tip Top décline toute responsabilité en cas de problème technique, informatique ou de mauvais
    fonctionnement du site et/ou du jeu-concours.</p>
        <h2>Données personnelles</h2>
        <p>Les données personnelles collectées lors de la participation au jeu-concours seront traitées conformément à
    la réglementation en vigueur et à la politique de confidentialité du site. Les participants disposent d'un
    droit d'accès, de rectification, d'opposition et de suppression de leurs données en contactant Thé Tip Top à
    l'adresse indiquée dans la section "Informations sur la société".</p>
        <h2>Droit applicable et juridiction compétente</h2>
        <p>Le présent jeu-concours est soumis au droit français. Tout litige sera soumis aux tribunaux compétents.</p>
        <h2>Modification des mentions légales</h2>
        <p>Thé Tip Top se réserve le droit de modifier à tout moment les présentes mentions légales. Les participants sont
    invités à consulter régulièrement les mentions légales pour prendre connaissance des éventuelles
    modifications.</p>
    </div>
    <p style="text-align: center;">
        Les présentes mentions légales ont été mises à jour le <strong>{{ date }}</strong>
    </p>
 </template>
   
   <script>
     export default {
       name: "MentionLegal",
       data(){
         return {
            date : this.currentDate()
         }
       },
       mounted() {
       },
       methods:{
        currentDate() {
        const dateObject = new Date();
        if (!isNaN(dateObject.getTime())) {
            const year = dateObject.getFullYear();
            let month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
            let day = dateObject.getDate().toString().padStart(2, '0');
            return `${day}/${month}/${year}`;
        } else {
            console.error(`La date "${dateString}" n'est pas valide.`);
            return null;
        }
    }
       }
     }
   </script>