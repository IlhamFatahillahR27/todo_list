<template>
    <v-card :variant="variant ?? 'outlined'" :class="classCard" :width="width">
        <v-card-item v-if="title || subtitle">
            <v-card-title>
                {{ title }}
                <slot name="title-card"/>
            </v-card-title>
            <v-card-subtitle>
                {{ subtitle }}
                <slot name="subtitle-card"/>
            </v-card-subtitle>
        </v-card-item>
        <v-card-text>
            <!-- in template do this -> '#body-card' to use this slot -->
            {{ text }}
            <slot name="body-card"/>
        </v-card-text>
    </v-card>
</template>
<script setup lang="ts">
const props = defineProps({
    title: String,
    subtitle: String,
    variant: String,
    classCard: String,
    text: String,
    width: String
})
</script>
