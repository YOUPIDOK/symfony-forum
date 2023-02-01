<template>
    <div class="relative">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 my-8">
            <div class="relative shadow-xl sm:overflow-hidden sm:rounded-2xl">
                <div class="absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-800 to-indigo-700 mix-blend-multiply"></div>
                </div>
                <div class="relative py-16 px-6 sm:py-24 lg:py-32 lg:px-8">
                    <h1 class="text-center text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                        <span class="block text-white">Le seul forum</span>
                        <span class="block text-indigo-200">qui a un site plutôt cool !</span>
                    </h1>
                    <p class="mx-auto mt-6 max-w-lg text-center text-xl text-indigo-200 sm:max-w-3xl">Une page en Vuejs car les devs adorent les nouvelles technologies.</p>
                    <div class="mx-auto mt-10 max-w-sm sm:flex sm:max-w-none sm:justify-center">
                        <div class="flex gap-4 items-center justify-center flex-wrap">
                            <a href="/atelier" class="flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-3 text-base font-medium text-indigo-700 shadow-sm hover:bg-indigo-50 sm:px-8">Découvrer les ateliers</a>
                            <a v-if="!haveUser" href="/creer-un-compte-etudiant" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-500 bg-opacity-60 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-opacity-70 sm:px-8">S'inscrire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        haveUser: Boolean
    });
</script>