<template>
    <Default>
        <template #body>
            <div class="v-row">
                <v-autocomplete
                    prepend-inner-icon="mdi-magnify"
                    class="v-col-sm-12 v-col-md-6 v-col-lg-4 v-col-xl-3 v-col-xxl-2"
                    :items="[
                        'California',
                        'Colorado',
                        'Florida',
                        'Georgia',
                        'Texas',
                        'Wyoming',
                    ]"
                    variant="outlined"
                >
                </v-autocomplete>
            </div>
            <v-sheet
                class="d-flex ga-5 flex-nowrap overflow-x-auto pb-3"
                width="100%"
                height="90%"
            >
                <template v-for="(item, index) in groupData" :key="index">
                    <v-sheet class="rounded-lg">
                        <v-card
                            width="400px"
                            height="100%"
                            variant="tonal"
                            :style="{
                                'background-color': item.color,
                                color: calculateColor(item.color),
                            }"
                        >
                            <v-card-title
                                class="d-flex flex-row justify-space-between align-center"
                            >
                                {{ item.title }}
                                <v-card-actions>
                                    <v-menu>
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                icon="mdi-palette"
                                                size="small"
                                                v-bind="props"
                                            ></v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item>
                                                <v-list-item-title
                                                    >Column
                                                    Color</v-list-item-title
                                                >
                                                <v-color-picker
                                                    v-model="item.color"
                                                    hide-inputs
                                                    show-swatches
                                                ></v-color-picker>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                    <v-menu>
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                icon="mdi-dots-vertical"
                                                size="small"
                                                v-bind="props"
                                            ></v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item value="Add">
                                                <v-list-item-title
                                                    >Add List</v-list-item-title
                                                >
                                            </v-list-item>
                                            <v-list-item value="Edit">
                                                <v-list-item-title
                                                    >Edit
                                                    Column</v-list-item-title
                                                >
                                            </v-list-item>
                                            <v-list-item value="Delete">
                                                <v-list-item-title
                                                    >Delete
                                                    Column</v-list-item-title
                                                >
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </v-card-actions>
                            </v-card-title>
                            <v-card-text class="overflow-y-auto">
                                <v-btn
                                    class="text-none mb-3"
                                    prepend-icon="mdi-plus-thick"
                                    variant="tonal"
                                    size="x-large"
                                    block
                                    >Add List</v-btn
                                >
                                <draggable
                                    v-model="item.tasks"
                                    group="tasks"
                                    @start="drag = true"
                                    @end="drag = false"
                                    item-key="id"
                                    class="d-flex overflow-y-auto flex-column ga-3"
                                    v-if="item"
                                >
                                    <template #item="{ element }">
                                        <v-sheet rounded="lg">
                                            <v-card
                                                variant="tonal"
                                                :style="{
                                                    'background-color':
                                                        item.color,
                                                    'color': calculateColor(
                                                        item.color
                                                    ),
                                                }"
                                                class="d-flex align-center"
                                            >
                                                <v-card-actions>
                                                    <v-checkbox
                                                        :hide-details="true"
                                                    ></v-checkbox>
                                                </v-card-actions>
                                                <v-card-item
                                                    class="flex-grow-1"
                                                >
                                                    <v-card-title>{{
                                                        element.name
                                                    }}</v-card-title>
                                                    <v-card-subtitle>{{
                                                        dateTimeFormatter(element.created_at)
                                                    }}</v-card-subtitle>
                                                </v-card-item>
                                                <v-card-actions>
                                                    <v-btn
                                                        icon="mdi-close"
                                                        variant="plain"
                                                        size="small"
                                                    ></v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-sheet>
                                    </template>
                                </draggable>

                                <rawDisplayer
                                    :value="item.tasks"
                                    title="tasks"
                                />
                            </v-card-text>
                        </v-card>
                    </v-sheet>
                </template>

                <v-sheet class="rounded-lg">
                    <AddColumn />
                </v-sheet>
            </v-sheet>
        </template>
    </Default>
</template>
<script lang="ts" setup>
import { onMounted, ref, watch } from "vue";
import draggable from "vuedraggable";
import AddColumn from "@/Pages/AddColumn.vue";
import Default from "@/Layouts/Default.vue";
import GroupInterface from "@/Interfaces/GroupInterface.ts";
import { dateTimeFormatter } from "@/src/helper/formatter.ts";

const props = defineProps({
    groups: Array as () => GroupInterface[],
});

const groupData = ref(props.groups);
const myArray = ref();
const myArray1 = ref();

onMounted(() => {});

const c2 = ref("#00ff00");
const textColor = ref("");

const calculateColor = (color) => {
    const rgb = color.match(/\d+/g);
    if (rgb) {
        const brightness =
            (parseInt(rgb[0]) * 299 +
                parseInt(rgb[1]) * 587 +
                parseInt(rgb[2]) * 114) /
            1000;
        if (brightness < 128) {
            return "#000000";
        } else {
            return "#ffffff";
        }
    }
};

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
