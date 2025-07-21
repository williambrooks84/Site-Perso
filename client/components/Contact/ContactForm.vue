<template>
    <section id="contact-form" class="flex flex-col justify-center items-center gap-8 p-8 w-fit md:w-full">
        <div class="form flex flex-col justify-center gap-4">
            <div class="form-content bg-white p-4 rounded-lg w-fit relative mx-auto mt-16 md:p-6 md:max-w-4/5">
                <p class="text-primary mb-4 text-xl text-center font-semibold md:text-3xl">Contactez-moi</p>
                <form @submit.prevent="send" class="flex flex-col gap-4">
                    <div class="input-name-group flex flex-row gap-4 md:gap-2">
                        <div class="input-group relative mb-6 md:mb-4">
                            <input id="firstname" v-model="form.firstname" type="text" placeholder=" " required
                                class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey bg-transparent outline-none focus:border-secondary" />
                            <label for="firstname"
                                class="absolute left-2 text-sm text-grey pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">
                                Prénom
                            </label>
                        </div>

                        <div class="input-group relative mb-6 md:mb-4">
                            <input id="lastname" v-model="form.lastname" type="text" placeholder=" " required
                                class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey bg-transparent outline-none focus:border-secondary" />
                            <label for="lastname"
                                class="absolute left-2 text-sm text-grey pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">Nom</label>
                        </div>
                    </div>

                    <div class="input-group relative mb-6 md:mb-4">
                        <input id="email" v-model="form.email" type="email" placeholder=" " required
                            class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey bg-transparent outline-none focus:border-secondary" />
                        <label for="email"
                            class="absolute left-2 text-sm text-grey pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">Email</label>
                    </div>

                    <div class="input-group relative mb-6 md:mb-4">
                        <input id="subject" v-model="form.subject" type="text" placeholder=" " required
                            class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey bg-transparent outline-none focus:border-secondary" />
                        <label for="subject"
                            class="absolute left-2 text-sm text-grey pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">Sujet</label>
                    </div>

                    <div class="input-group relative mb-6 md:mb-4">
                        <textarea id="message" v-model="form.message" rows="4" placeholder=" " required
                            class="peer w-full pt-5 pb-2 px-2 text-base border-2 rounded-lg border-border-grey bg-transparent outline-none focus:border-secondary"></textarea>
                        <label for="message"
                            class="absolute left-2 text-sm text-grey pointer-events-none transition-all px-1 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-grey peer-focus:top-1 peer-focus:text-xs peer-focus:text-secondary">Message</label>
                    </div>

                    <button type="submit"
                        class="btn btn-primary cursor-pointer mx-auto px-4 py-2 text-base bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        :disabled="loading">
                        {{ loading ? 'Envoi en cours...' : 'Envoyer' }}
                    </button>
                </form>
                <p v-if="sent" class="success-message mt-4 text-green-500">Merci, votre message a été envoyé !</p>
                <p v-if="error" class="error-message mt-4 text-red-500">{{ error }}</p>
            </div>
        </div>
        <div v-if="showToast" class="fixed top-8 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-[9999] text-lg font-semibold">
            J'ai bien reçu votre message
        </div>
        <canvas ref="confettiCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-[9998]" v-show="showConfetti"></canvas>
    </section>
</template>

<script setup>
import { ref, reactive } from 'vue'

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

const send = async () => {
    error.value = null
    loading.value = true
    
    try {
        const response = await fetch('https://script.google.com/macros/s/AKfycbwxSOMqwpcIMsVHqy8u8krSJgMtdIHRrZceZ9873jj4UELFVIeABJU5uprUAuJVITc3cQ/exec', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(form),
            mode: 'no-cors' // Important for Google Apps Script
        });

        // Since we're using no-cors mode, we can't read the response
        // But we assume success if no error was thrown
        sent.value = true
        showToast.value = true
        showConfetti.value = true
        
        // Reset form after 2 seconds
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