<template>
    <section id="contact-form" class="flex flex-col justify-center items-center gap-8 p-8 w-fit md:w-full">
        <div class="form flex flex-col justify-center gap-4">
            <div class="form-content bg-white dark:bg-primary-dark p-4 rounded-lg w-fit relative mx-auto mt-16 md:p-6 md:max-w-4/5 shadow-md">
                <p class="text-primary dark:text-secondary mb-4 text-xl text-center font-semibold md:text-3xl">Contactez-moi</p>
                <form @submit.prevent="send" class="flex flex-col gap-4">
                    <div class="input-name-group flex flex-row gap-4 md:gap-2">
                        <div class="input-group relative mb-6 md:mb-4">
                            <input
                                id="firstname"
                                v-model="form.firstname"
                                type="text"
                                placeholder=" "
                                required
                                @input="touched.firstname = true"
                                class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey dark:border-border-dark bg-transparent text-primary dark:text-light outline-none focus:border-secondary dark:focus:border-secondary"
                            />
                            <label for="firstname" class="absolute left-2 text-sm text-grey dark:text-light pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey dark:peer-placeholder-shown:text-light peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">
                                Prénom
                            </label>
                            <span v-if="touched.firstname && !verifyFirstName(form.firstname)" class="text-red-500 text-xs absolute left-2 top-full">Le prénom est requis.</span>
                        </div>
                        <div class="input-group relative mb-6 md:mb-4">
                            <input
                                id="lastname"
                                v-model="form.lastname"
                                type="text"
                                placeholder=" "
                                required
                                @input="touched.lastname = true"
                                class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey dark:border-border-dark bg-transparent text-primary dark:text-light outline-none focus:border-secondary dark:focus:border-secondary"
                            />
                            <label for="lastname" class="absolute left-2 text-sm text-grey dark:text-light pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey dark:peer-placeholder-shown:text-light peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">
                                Nom
                            </label>
                            <span v-if="touched.lastname && !verifyLastName(form.lastname)" class="text-red-500 text-xs absolute left-2 top-full">Le nom est requis.</span>
                        </div>
                    </div>
                    <div class="input-group relative mb-6 md:mb-4">
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder=" "
                            required
                            @input="touched.email = true"
                            class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey dark:border-border-dark bg-transparent text-primary dark:text-light outline-none focus:border-secondary dark:focus:border-secondary"
                        />
                        <label for="email" class="absolute left-2 text-sm text-grey dark:text-light pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey dark:peer-placeholder-shown:text-light peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">
                            Email
                        </label>
                        <span v-if="touched.email && !verifyEmail(form.email)" class="text-red-500 text-xs absolute left-2 top-full">Adresse email invalide.</span>
                    </div>
                    <div class="input-group relative mb-6 md:mb-4">
                        <input
                            id="subject"
                            v-model="form.subject"
                            type="text"
                            placeholder=" "
                            required
                            @input="touched.subject = true"
                            class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey dark:border-border-dark bg-transparent text-primary dark:text-light outline-none focus:border-secondary dark:focus:border-secondary"
                        />
                        <label for="subject" class="absolute left-2 text-sm text-grey dark:text-light pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey dark:peer-placeholder-shown:text-light peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">
                            Sujet
                        </label>
                        <span v-if="touched.subject && !verifySubject(form.subject)" class="text-red-500 text-xs absolute left-2 top-full">Le sujet est requis.</span>
                    </div>
                    <div class="input-group relative mb-6 md:mb-4">
                        <textarea
                            id="message"
                            v-model="form.message"
                            rows="4"
                            placeholder=" "
                            required
                            @input="touched.message = true"
                            class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey dark:border-border-dark bg-transparent text-primary dark:text-light outline-none focus:border-secondary dark:focus:border-secondary"
                        ></textarea>
                        <label for="message" class="absolute left-2 text-sm text-grey dark:text-light pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey dark:peer-placeholder-shown:text-light peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">
                            Message
                        </label>
                        <span v-if="touched.message && !verifyMessage(form.message)" class="text-red-500 text-xs absolute left-2 top-full">Le message est requis.</span>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary cursor-pointer mx-auto px-4 py-2 text-base bg-secondary dark:bg-secondary-dark text-white rounded-md hover:bg-blue-600"
                        :disabled="loading"
                    >
                        {{ loading ? 'Envoi en cours...' : 'Envoyer' }}
                    </button>
                </form>
                <p v-if="error" class="error-message mt-4 text-red-500">{{ error }}</p>
            </div>
        </div>
        <div v-if="showToast" class="fixed top-8 left-1/2 transform -translate-x-1/2 bg-green-500 dark:bg-green-700 text-white px-6 py-3 rounded shadow-lg z-[9999] text-lg font-semibold">
            J'ai bien reçu votre message
        </div>
        <div v-if="showInvalidPopup" class="fixed top-8 left-1/2 transform -translate-x-1/2 bg-red-500 dark:bg-red-700 text-white px-6 py-3 rounded shadow-lg z-[9999] text-lg font-semibold">
            Informations incorrectes ou manquantes
        </div>
        <canvas ref="confettiCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-[9998]" v-show="showConfetti"></canvas>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue'

const touched = reactive({
    firstname: false,
    lastname: false,
    email: false,
    subject: false,
    message: false,
})

const verifyEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return re.test(email)
}
const verifyFirstName = (firstname) => {
    return firstname.length > 0 && firstname.length <= 50
}
const verifyLastName = (lastname) => {
    return lastname.length > 0 && lastname.length <= 50
}
const verifySubject = (subject) => {
    return subject.length > 0 && subject.length <= 100
}
const verifyMessage = (message) => {
    return message.length > 0 && message.length <= 500
}

const verifyForm = () => {
    return (
        verifyFirstName(form.firstname) &&
        verifyLastName(form.lastname) &&
        verifyEmail(form.email) &&
        verifySubject(form.subject) &&
        verifyMessage(form.message)
    )
}

const form = reactive({
    firstname: '',
    lastname: '',
    subject: '',
    email: '',
    message: '',
})

const sent = ref(false)
const showToast = ref(false)
const showConfetti = ref(false)
const loading = ref(false)
const error = ref(null)
const confettiCanvas = ref(null)
const showInvalidPopup = ref(false)

const send = async () => {
    error.value = null
    loading.value = true

    // If form is invalid, show popup and block submit
    if (!verifyForm()) {
        Object.keys(touched).forEach(key => touched[key] = true)
        showInvalidPopup.value = true
        loading.value = false
        setTimeout(() => showInvalidPopup.value = false, 2000)
        return
    }

    try {
        const response = await fetch('https://script.google.com/macros/s/AKfycbwoQ1dUmqGQBjrl9aa642xMDgnuYvQYp68qzL9gWZD_YSc-bkXUWS2zHj5XEL3-BGO8XQ/exec', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(form),
            mode: 'no-cors'
        });

        sent.value = true
        showToast.value = true
        showConfetti.value = true

        setTimeout(() => {
            Object.keys(form).forEach(key => form[key] = '')
            sent.value = false
            showToast.value = false
            showConfetti.value = false
        }, 2000)

    } catch (e) {
        console.error('Error:', e)
        error.value = "Une erreur est survenue lors de l'envoi. Veuillez réessayer plus tard."
    } finally {
        loading.value = false
    }
}
</script>