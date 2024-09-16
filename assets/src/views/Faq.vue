<template>
    <title>FAQ | The Tip Top</title>
    <h1>FAQ - Tout savoir sur le jeu-concours</h1>
<p>Bienvenue sur la page FAQ du jeu-concours Thé Tip Top ! Vous trouverez ici toutes les réponses à vos questions
    concernant notre fantastique concours, organisé pour célébrer l'ouverture de notre 10ème boutique à Nice et pour
    faire découvrir nos délicieux thés bios et Handmades à de nouveaux amateurs. Que vous souhaitiez en savoir plus
    sur les conditions de participation, les gains possibles ou la procédure de réclamation de votre lot, vous êtes
    au bon endroit ! Nous avons regroupé les questions les plus fréquemment posées pour vous fournir toutes les
    informations dont vous avez besoin. N'hésitez pas à parcourir cette page et si vous avez encore des questions,
    notre équipe est là pour vous aider. Bonne chance et bonne dégustation !</p>
<div class="faq">
    <div>
        <h2>Qu'est-ce que le jeu-concours Thé Tip Top ?</h2>
        <p> Le jeu-concours Thé Tip Top est une opération promotionnelle organisée par la société Thé Tip Top pour célébrer
    l'ouverture de leur 10ème boutique et attirer de nouveaux clients. Les participants peuvent gagner divers
    lots en entrant le numéro à 10 chiffres figurant sur leur ticket de caisse ou leur facture de plus de 49€.</p>
    </div>
    <div>
        <h2>Comment puis-je participer au jeu-concours ?</h2>
        <p>Pour participer au jeu-concours, vous devez effectuer un achat d'un montant supérieur à 49€ dans une
    boutique Thé Tip Top. Vous recevrez un ticket de caisse ou une facture avec un numéro unique à 10 chiffres.
    Inscrivez-vous sur notre site en entrant ce numéro et vos coordonnées pour valider votre participation.</p>
    </div>
    <div>
        <h2>Quels sont les lots à gagner ?</h2>
        <p>Tous les tickets sont gagnants. Voici la répartition des gains :</p>
        <ul>
            <li>60% des tickets offrent un infuseur à thé</li>
            <li>20% des tickets offrent une boite de 100g d'un thé détox ou d'infusion</li>
            <li>10% des tickets offrent une boite de 100g d'un thé signature</li>
            <li>6% des tickets offrent un coffret découverte d'une valeur de 39€</li>
            <li>4% des tickets offrent un coffret découverte d'une valeur de 69€</li>
        </ul>
        <p>Un tirage au sort final déterminera le gagnant d'un an de thé d'une valeur de 360€.</p>
    </div>
    <div>
        <h2>Combien de temps dure le jeu-concours ?</h2>
        <p>Le jeu-concours se déroule sur une période de 30 jours. Les participants ont jusqu'à 30 jours après la fin
    du concours pour entrer leur numéro de ticket sur le site et réclamer leur lot.</p>
    </div>
    <div>
        <h2>Comment savoir si j'ai gagné ?</h2>
        <p>Une fois que vous avez entré votre numéro de ticket à 10 chiffres et vos coordonnées sur notre site, vous
    recevrez une notification indiquant le lot que vous avez gagné. Les instructions pour réclamer votre lot en
    magasin ou en ligne seront également fournies.</p>
    </div>
    <div>
        <h2>Y a-t-il des conditions d'éligibilité pour participer au jeu-concours ?</h2>
        <p>Les participants doivent être âgés de 18 ans ou plus et résider dans le pays où se déroule le jeu-concours.
    Les employés de Thé Tip Top, leurs familles et toute personne impliquée dans l'organisation du jeu-concours ne
    sont pas éligibles. Consultez les conditions générales du jeu-concours pour plus d'informations.</p>
    </div>
    <div>
        <h2>Comment puis-je réclamer mon lot ?</h2>
        <p>Suivez les instructions fournies sur le site après avoir entré votre numéro de ticket. Vous pourrez réclamer
    votre lot en magasin en présentant votre ticket de caisse ou votre facture, ou en ligne en suivant les
    étapes indiquées.</p>
    </div>
    <div>
        <h2>Combien de fois puis-je participer ?</h2>
        <p>Vous pouvez participer autant de fois que vous le souhaitez.</p>
    </div>
</div>
  </template>
  
  <script>
    export default {
      name: "Faq",
      mounted() {
        $(".faq>div p, .faq ul").hide();
        $(".faq>div").on("click", function () {
          $(".faq p, .faq ul").not($(this).find("p, ul")).slideUp();
          $(this).find("p, ul").slideToggle();
        });
      }
    }
  </script>
  