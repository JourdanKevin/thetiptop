<template>
  <title>Bienvenue | The Tip Top</title>
  <div class="home">
    <h1>Participez et gagnez des cadeaux exceptionnels !</h1>
    <p>Thé Tip Top, votre spécialiste du thé haut de gamme, vous invite à découvrir nos gammes de thés d'exception,
        alliant saveurs uniques et qualité irréprochable. Nous sommes fiers de vous proposer des mélanges signatures,
        des thés détox, des thés blancs, des thés légumes, des infusions, et bien plus encore. Tous nos thés sont
        certifiés biologiques et fabriqués à la main avec soin et passion. À l'occasion de l'ouverture de notre 10ème
        boutique à Nice, nous avons le plaisir de vous convier à participer à notre grand jeu-concours, où chaque ticket
        est gagnant ! Ne manquez pas cette opportunité de goûter à la qualité Thé Tip Top et de remporter des cadeaux
        exceptionnels.
    </p>
     <div>
        <img src="/images/boite_the_signature.webp" alt="theiere">
        <img src="/images/coffret_39.webp" alt="coffret39">
        <img src="/images/coffret_69.webp" alt="coffret69">
    </div>
    <router-link :to="{ name: 'login', query: { redirectTo: 'prize' } }" class="btn">Participer</router-link>
</div>
</template>

<script>
  export default {
    name: "Home"
  }
</script>
