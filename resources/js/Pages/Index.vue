<template>
    <v-app>
        <v-container>
            <v-card title="Card title" subtitle="Subtitle" variant="outlined">
                <v-card-text>
                    <draggable
                        v-model="myArray"
                        group="people"
                        @start="drag = true"
                        @end="drag = false"
                        item-key="id"
                        class="list-group"
                    >
                        <template #item="{ element }">
                            <v-card
                                variant="outlined"
                                :text="element.name"
                                class="mb-2 list-group-item"
                            />
                        </template>
                    </draggable>
                </v-card-text>
            </v-card>
        </v-container>
    </v-app>
</template>
<script lang="ts" setup>
import { ref } from "vue";
import draggable from "vuedraggable";

const myArray = ref([
    { id: 1, name: "John" },
    { id: 2, name: "Joao" },
    { id: 3, name: "Jean" },
]);

const enabled = ref(true);

const drag = ref(false);
</script>

<style scoped>
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.not-draggable {
    cursor: no-drop;
}
</style>
