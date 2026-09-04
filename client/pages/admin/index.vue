<template>
	<main class="mx-auto flex min-h-[60vh] w-full max-w-5xl items-center justify-center px-4 py-12 sm:px-8">
		<section class="w-full max-w-md rounded-2xl border border-border-grey bg-light p-8 shadow-lg sm:p-10">
			<header class="mb-8 text-center">
				<h1 class="mb-3 text-3xl sm:text-4xl">Administration</h1>
			</header>

			<form class="space-y-5" @submit.prevent="submitLogin">
				<div>
					<label for="email" class="mb-2 block text-sm font-semibold text-dark">Adresse mail</label>
					<input
						id="email"
						v-model="form.email"
						name="email"
						type="email"
						autocomplete="email"
						required
						class="w-full rounded-lg border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
					/>
				</div>

				<div>
					<label for="password" class="mb-2 block text-sm font-semibold text-dark">Mot de passe</label>
					<input
						id="password"
						v-model="form.password"
						name="password"
						type="password"
						autocomplete="current-password"
						required
						class="w-full rounded-lg border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
					/>
				</div>

				<p v-if="errorMessage" class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
					{{ errorMessage }}
				</p>

				<button type="submit" class="btn-primary w-full" :disabled="isSubmitting">
					{{ isSubmitting ? 'Connexion...' : 'Se connecter' }}
				</button>
			</form>
		</section>
	</main>
</template>

<script setup>
import { onMounted, ref } from 'vue'

definePageMeta({
	middleware: 'admin',
})

const config = useRuntimeConfig()
const router = useRouter()
const apiUrl = config.public.apiUrl || 'https://api.willbrooks.fr'
const { isAuthenticated } = useAuth()

const form = ref({
	email: '',
	password: '',
})
const errorMessage = ref('')
const isSubmitting = ref(false)

const redirectAuthenticatedUser = async () => {
	try {
		const response = await $fetch(`${apiUrl}/api/me`, {
			credentials: 'include',
		})

		if (response?.roles?.includes('ROLE_ADMIN')) {
			await router.replace('/admin/projects')
		}
	} catch {
		// An unauthenticated visitor stays on the login page.
	}
}

const submitLogin = async () => {
	isSubmitting.value = true
	errorMessage.value = ''

	try {
		const response = await fetch(`${apiUrl}/api/login`, {
			method: 'POST',
			credentials: 'include',
			headers: {
				Accept: 'application/json',
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(form.value),
		})

		if (!response.ok) {
			throw new Error(response.status === 401 ? 'Adresse e-mail ou mot de passe incorrect.' : 'La connexion est momentanément indisponible.')
		}

		isAuthenticated.value = true
		await router.push('/admin/projects')
	} catch (error) {
		errorMessage.value = error instanceof Error ? error.message : 'Une erreur est survenue.'
	} finally {
		isSubmitting.value = false
	}
}

onMounted(redirectAuthenticatedUser)
</script>
