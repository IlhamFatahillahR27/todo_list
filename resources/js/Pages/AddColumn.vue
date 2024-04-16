<template>
    <v-card
        variant="tonal"
        width="400px"
        height="100%"
        @click="store.addGroup()"
        class="d-flex flex-column justify-center align-center"
    >
        <v-icon icon="mdi-plus-circle" size="100px"></v-icon>
        <v-card-title> ADD COLUMN </v-card-title>
        <v-card-subtitle> Use to group many list </v-card-subtitle>
    </v-card>
</template>
<script setup lang="ts" name="page_add_column">
import { useGroupStore } from "@/src/stores/group.js";

const store = useGroupStore();
</script>
