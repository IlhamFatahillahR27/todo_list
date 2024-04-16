<template>
    <Default>
        <template #body>
            <div class="v-row">
                <div
                    class="v-col-sm-12 v-col-md-6 v-col-lg-4 v-col-xl-3 v-col-xxl-2"
                >
                    <v-autocomplete
                        prepend-inner-icon="mdi-magnify"
                        :items="[
                            'California',
                            'Colorado',
                            'Florida',
                            'Georgia',
                            'Texas',
                            'Wyoming',
                        ]"
                        variant="outlined"
                        v-if="searchFeatures"
                    >
                        <template v-slot:append>
                            <v-btn
                                icon
                                variant="tonal"
                                color="error"
                                class="me-3"
                            >
                                <v-icon icon="mdi-restart"></v-icon>
                                <v-tooltip activator="parent" location="bottom"
                                    >Reset Search</v-tooltip
                                >
                            </v-btn>
                            <v-btn
                                icon
                                variant="tonal"
                                color="primary"
                                v-if="store.groups.length >= 2"
                            >
                                <v-icon icon="mdi-plus-thick"></v-icon>
                                <v-tooltip activator="parent" location="bottom"
                                    >Add Column</v-tooltip
                                >
                            </v-btn>
                        </template>
                    </v-autocomplete>
                    <v-btn
                        prepend-icon="mdi-plus-thick"
                        variant="tonal"
                        color="primary"
                        rounded="lg"
                        size="x-large"
                        class="text-none mb-4"
                        @click="store.addGroup()"
                        >Add Column</v-btn
                    >
                </div>
            </div>
            <v-sheet
                class="d-flex ga-5 flex-nowrap overflow-x-auto pb-3"
                width="100%"
                height="90%"
            >
                <Group />

                <v-sheet class="rounded-lg">
                    <AddColumn />
                </v-sheet>
            </v-sheet>
        </template>
    </Default>
</template>
<script lang="ts" setup>
import { onBeforeUnmount, onMounted, ref, watch } from "vue";
import AddColumn from "@/Pages/AddColumn.vue";
import Default from "@/Layouts/Default.vue";
import Group from "@/Pages/Group/Index.vue";
import GroupInterface from "@/Interfaces/GroupInterface.ts";
import { useGroupStore } from "@/src/stores/group.js";

const props = defineProps({
    groups: Array as () => GroupInterface[],
    complete_group: Object as () => GroupInterface[],
});

const store = useGroupStore();
const groupData = ref(props.groups);
const completeGroup = ref(props.complete_group);
const searchFeatures = import.meta.env.VITE_FEATURE_SEARCH;

onMounted(() => {
    store.groups = groupData.value;
    store.groups.push(completeGroup.value);
});

onBeforeUnmount(() => {
    store.groups = [];
    store.taskLoading = null;
    store.groupLoading = null;
});
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
