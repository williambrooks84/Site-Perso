<template>
  <div class="max-w-3xl mx-auto py-12 px-4">
    <h1 class="text-primary text-3xl md:text-5xl font-bold mb-8 text-center">Mentions légales</h1>
    <section class="mb-8">
      <h2 class="text-xl font-semibold mb-2">Éditeur du site</h2>
      <p>
        Ce site portfolio appartient à :<br>
        <span class="font-bold">William Brooks</span><br>
        Limoges, France<br>
        Email : <a href="mailto:william.brooks@etu.unilim.fr" class="text-secondary hover:underline">william.brooks@etu.unilim.fr</a>
      </p>
    </section>
    <section class="mb-8">
      <h2 class="text-xl font-semibold mb-2">Hébergement</h2>
      <p>
        Le site est hébergé par :<br>
        <span class="font-bold">PulseHeberg</span><br>
        9, Boulevard de Strasbourg, 83000 Toulon<br>
        <a href="https://pulseheberg.com/fr" target="_blank" rel="noopener" class="text-secondary hover:underline">https://pulseheberg.com/fr</a>
      </p>
    </section>
    <section class="mb-8">
      <h2 class="text-xl font-semibold mb-2">Propriété intellectuelle</h2>
      <p>
        L'ensemble des contenus (textes, images, graphismes, logo, icônes, etc.) présents sur ce site sont la propriété de William Brooks, sauf les icônes qui sont la propriété de leurs auteurs respectifs (comme les logos des logiciels et outils de développement). Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable.
      </p>
    </section>
    <section class="mb-8">
      <h2 class="text-xl font-semibold mb-2">Données personnelles</h2>
      <p>
        Ce site ne collecte pas de données personnelles à des fins commerciales. Les informations transmises via le formulaire de contact sont utilisées uniquement pour répondre à votre demande et ne sont pas conservées ni transmises à des tiers.
      </p>
    </section>
    <section>
      <h2 class="text-xl font-semibold mb-2">Cookies</h2>
      <p>
        Ce site utilise des cookies techniques nécessaires à son fonctionnement (préférences de thème, etc.). Aucun cookie publicitaire ou de suivi n'est utilisé.
      </p>
    </section>
  </div>
</template>

<script setup>
useHead({
  title: 'William Brooks - Mentions légales',
  meta: [
    {
      name: 'description',
      content: 'Retrouvez les mentions légales du site portfolio de William Brooks, développeur web étudiant à Limoges.'
    },
    {
      name: 'keywords',
      content: 'développeur web, développeur front-end, étudiant, Limoges, informatique'
    },
    {
      property: 'og:title',
      content: 'William Brooks - Développeur Web sur Limoges'
    },
    {
      property: 'og:description',
      content: 'William Brooks est un développeur web étudiant à Limoges, intéressé par l\'informatique depuis un jeune âge.'
    },
    {
      property: 'og:url',
      content: 'https://willbrooks.fr'
    },
    {
      property: 'og:type',
      content: 'website'
    }
  ]
})
</script>

<style scoped>
</style>