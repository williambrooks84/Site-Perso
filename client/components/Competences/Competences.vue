<template>
    <section id="competences" class="space-y-8 mt-15">
        <h2>Que sais-je faire ?</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div
                v-for="competence in competences"
                :key="competence.nom"
                class="group flex items-center gap-4 p-5
                       bg-light text-dark border border-border-grey rounded-xl
                       transition-all duration-200
                       hover:-translate-y-1 hover:bg-hover hover:text-primary
                       hover:border-primary hover:shadow-lg"
            >
                <div
                    class="flex items-center justify-center shrink-0
                           w-12 h-12 rounded-lg
                           bg-primary text-light
                           transition-transform duration-200
                           group-hover:scale-110"
                >
                    <i :class="`aria-hidden=true bi ${competence.icone} text-xl`"></i>
                </div>

                <span class="text-base lg:text-xl font-semibold">
                    {{ competence.nom }}
                </span>
            </div>
        </div>
    </section>
</template>

<script setup>
const competences = [
    {
        nom: "Développement d'applications et sites Web",
        icone: "bi-globe2"
    },
    {
        nom: "Déploiement automatique de projets via un pipeline CI/CD",
        icone: "bi-arrow-repeat"
    },
    {
        nom: "Conception d'interfaces responsives",
        icone: "bi-phone"
    },
    {
        nom: "Représentation graphique de données",
        icone: "bi-bar-chart"
    },
    {
        nom: "Conception et intégration d'API",
        icone: "bi-plug"
    },
    {
        nom: "Conception de bases de données",
        icone: "bi-database"
    },
    {
        nom: "Tests et débogage d'applications",
        icone: "bi-bug"
    },
    {
        nom: "Conteneurisation d'applications",
        icone: "bi-box"
    }
];
</script>