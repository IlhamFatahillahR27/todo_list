<template>
    <v-layout>
        <v-app-bar :elevation="2">
            <v-app-bar-title>{{ viteAppName }}</v-app-bar-title>
        </v-app-bar>
        <v-main class="h-screen">
            <div  class="h-100 pa-6">
                <slot name="body"/>
            </div>
        </v-main>
    </v-layout>
</template>
<script setup lang="ts" name="layout_default">
const viteAppName = import.meta.env.VITE_APP_NAME;
import { ref } from "vue";

const selected = ref(null);
const options = ref(["list", "of", "options"]);
</script>
