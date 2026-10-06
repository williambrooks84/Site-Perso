<template>
    <main class="mx-auto w-200 max-w-full px-4 py-12">
        <section class="rounded-2xl border border-border-grey bg-light p-8 shadow-sm">
            <header class="flex flex-col items-center justify-between gap-4">
                <h1 class="text-3xl font-bold text-dark">
                    Administration des designs
                </h1>

                <NuxtLink
                    to="/admin/designs/new"
                    class="btn-primary text-sm"
                >
                    Ajouter un design
                </NuxtLink>

                <NuxtLink
                    to="/admin/projects"
                    class="btn-primary text-sm"
                >
                    Voir les projets
                </NuxtLink>
            </header>

            <div
                v-if="message"
                class="mb-6 rounded-xl border px-4 py-3 text-sm"
                :class="
                    message.type === 'success'
                        ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                        : 'border-red-200 bg-red-50 text-red-700'
                "
            >
                {{ message.text }}
            </div>

            <DesignList
                :designs="designs"
                :removing-design-id="removingDesignId"
                :api-base-url="apiBaseUrl"
                @refresh="loadDesigns"
                @delete="deleteDesign"
                @edit="openEditModal"
            />
        </section>

        <!-- Edit modal -->
        <DesignEditModal
            :is-open="isEditModalOpen"
            :design="editingDesign"
            :api-base-url="apiBaseUrl"
            :is-submitting="isUpdatingDesign"
            @close="closeEditModal"
            @submit="updateDesignFromModal"
        />
    </main>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import {
    updateDesign,
    deleteDesign as deleteDesignRequest,
} from '~/utils/designApi'

import DesignList from '~/components/Admin/DesignList.vue'
import DesignEditModal from '~/components/Admin/DesignEditModal.vue'

definePageMeta({
    middleware: 'admin',
})

const runtimeConfig = useRuntimeConfig()

const apiBaseUrl =
    runtimeConfig.public.apiUrl || 'https://api.willbrooks.fr'

const designs = ref([])

const message = ref(null)
const removingDesignId = ref(null)

const isEditModalOpen = ref(false)
const editingDesign = ref(null)
const isUpdatingDesign = ref(false)

const loadDesigns = async () => {
    try {
        const response = await fetch(`${apiBaseUrl}/api/designs`, {
            headers: {
                Accept: 'application/ld+json',
            },
        })

        if (!response.ok) {
            throw new Error('Impossible de charger les designs')
        }

        const data = await response.json()

        designs.value = data.member || data
    } catch (error) {
        console.error('Erreur chargement designs:', error)
    }
}

const deleteDesign = async design => {
    if (!window.confirm(`Supprimer le design « ${design.title} » ?`)) {
        return
    }

    removingDesignId.value = design.id
    message.value = null

    try {
        await deleteDesignRequest(
            design.id,
            apiBaseUrl
        )

        message.value = {
            type: 'success',
            text: 'Le design a bien été supprimé.',
        }

        await loadDesigns()
    } catch (error) {
        message.value = {
            type: 'error',
            text:
                error instanceof Error
                    ? error.message
                    : 'Impossible de supprimer le design.',
        }
    } finally {
        removingDesignId.value = null
    }
}

const openEditModal = design => {
    editingDesign.value = design
    isEditModalOpen.value = true
    message.value = null
}

const closeEditModal = () => {
    if (isUpdatingDesign.value) {
        return
    }

    isEditModalOpen.value = false
    editingDesign.value = null
}

const updateDesignFromModal = async form => {
    if (!editingDesign.value) {
        return
    }

    isUpdatingDesign.value = true
    message.value = null

    try {
        const updatedDesign = await updateDesign(
            editingDesign.value.id,
            {
                title: form.title.trim(),
                description: form.description.trim(),
                image: form.image,
                previewImage: form.previewImage,
            },
            apiBaseUrl
        )

        const index = designs.value.findIndex(
            design => design.id === updatedDesign.id
        )

        if (index !== -1) {
            designs.value[index] = updatedDesign
        }

        message.value = {
            type: 'success',
            text: 'Le design a bien été modifié.',
        }

        isEditModalOpen.value = false
        editingDesign.value = null
    } catch (error) {
        message.value = {
            type: 'error',
            text:
                error instanceof Error
                    ? error.message
                    : 'Impossible de modifier le design.',
        }
    } finally {
        isUpdatingDesign.value = false
    }
}

onMounted(() => {
    loadDesigns()
})
</script>

<style scoped>
input,
textarea {
    font: inherit;
}
</style>