<template>
    <v-sheet
        class="rounded-lg"
        v-for="(item, index) in store.groups"
        :key="index"
    >
        <v-card
            width="400px"
            height="100%"
            variant="tonal"
            :style="{
                'background-color': item.color,
                color: calculateColor(item.color),
            }"
            :loading="store.groupLoading == index"
        >
            <v-card-title
                class="d-flex flex-row justify-space-between align-center"
                v-if="store.editedGroup != index"
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
                                    >Column Color</v-list-item-title
                                >
                                <v-color-picker
                                    v-model="item.color"
                                    hide-sliders
                                    hide-canvas
                                    show-swatches
                                    :update:modelValue="
                                        store.changeColor(item.color, item.id)
                                    "
                                ></v-color-picker>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <v-menu v-if="!item.for_complete">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                icon="mdi-dots-vertical"
                                size="small"
                                v-bind="props"
                            ></v-btn>
                        </template>

                        <v-list>
                            <v-list-item
                                value="Add"
                                @click="store.addTask(index)"
                            >
                                <v-list-item-title>Add List</v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                value="Edit"
                                @click="
                                    [
                                        (store.editedGroup = index),
                                        (store.itemEditBefore = { ...item }),
                                    ]
                                "
                                v-if="!item.is_default"
                            >
                                <v-list-item-title
                                    >Edit Column</v-list-item-title
                                >
                            </v-list-item>
                            <v-list-item
                                value="Delete"
                                @click="store.deleteGroup(item.id, index)"
                                v-if="!item.is_default"
                            >
                                <v-list-item-title
                                    >Delete Column</v-list-item-title
                                >
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-card-actions>
            </v-card-title>
            <v-card-title v-else>
                <v-form
                    class="d-flex flex-row justify-space-between align-center mt-4"
                    @submit.prevent="store.saveEditGroup(index, item)"
                >
                    <v-text-field
                        v-model="item.title"
                        clearable
                        hide-details
                        label="Column Title"
                        variant="outlined"
                    ></v-text-field>
                    <v-card-actions class="d-flex justify-end align-center">
                        <v-btn
                            icon
                            size="small"
                            @click="store.cancelEditGroup(index)"
                        >
                            <v-icon icon="mdi-close"></v-icon>
                            <v-tooltip activator="parent" location="bottom"
                                >Cancel</v-tooltip
                            >
                        </v-btn>
                        <v-btn
                            icon
                            size="small"
                            @click="store.saveEditGroup(index, item)"
                            type="submit"
                        >
                            <v-icon icon="mdi-check"></v-icon>
                            <v-tooltip activator="parent" location="bottom"
                                >Save</v-tooltip
                            >
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-title>
            <v-card-text class="overflow-y-auto">
                <v-btn
                    class="text-none mb-3"
                    prepend-icon="mdi-plus-thick"
                    variant="tonal"
                    size="x-large"
                    block
                    @click="store.addTask(index)"
                    v-if="item.tasks.length == 0 && !item.for_complete"
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
                    <template #item="{ element, index: elIndex }">
                        <v-sheet rounded="lg">
                            <v-card
                                variant="tonal"
                                :style="{
                                    'background-color': item.color,
                                    color: calculateColor(item.color),
                                }"
                                class="d-flex align-center"
                                :loading="store.taskLoading == element.id"
                                v-if="element.id != null"
                            >
                                <v-card-actions>
                                    <v-checkbox
                                        :hide-details="true"
                                        v-model="element.completed"
                                        :checked="element.completed"
                                        :value="1"
                                        :disabled="store.editedGroup == index"
                                        @change="
                                            store.completeTask(
                                                element.completed,
                                                element.id,
                                                index,
                                                elIndex
                                            )
                                        "
                                    ></v-checkbox>
                                </v-card-actions>
                                <v-card-item class="flex-grow-1">
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
                                        :disabled="store.editedGroup == index"
                                        @click="
                                            store.deleteTask(
                                                element.id,
                                                elIndex,
                                                index
                                            )
                                        "
                                    ></v-btn>
                                </v-card-actions>
                            </v-card>
                            <v-card
                                variant="tonal"
                                :style="{
                                    'background-color': item.color,
                                    color: calculateColor(item.color),
                                }"
                                class="d-flex align-center"
                                :loading="store.taskLoading"
                                v-else
                            >
                                <v-card-text>
                                    <v-text-field
                                        v-model="element.name"
                                        clearable
                                        label="Title"
                                        variant="outlined"
                                        @input="
                                            store.checkExistTask(element.name)
                                        "
                                    >
                                        <template #details>
                                            <v-message>
                                                <template
                                                    v-if="
                                                        store.validNewTask !=
                                                        null
                                                    "
                                                >
                                                    <span
                                                        v-if="
                                                            store.validNewTask
                                                        "
                                                    >
                                                        Title is freshly new
                                                    </span>
                                                    <span v-else>
                                                        Title is already
                                                        available.
                                                        <a
                                                            class="text-caption text-decoration-none"
                                                            :style="{
                                                                color: calculateColor(
                                                                    item.color
                                                                ),
                                                            }"
                                                            href="#"
                                                            rel="noopener noreferrer"
                                                            @click="store.detailViewed = true"
                                                        >
                                                            <b
                                                                >See details here...</b
                                                            ></a
                                                        >
                                                    </span>
                                                </template>
                                                <span v-else>
                                                    Title is required
                                                </span>
                                            </v-message>
                                        </template>
                                        <template v-slot:append>
                                            <v-btn
                                                :icon="
                                                    store.validNewTask != null
                                                        ? store.validNewTask
                                                            ? 'mdi-check'
                                                            : 'mdi-close'
                                                        : 'mdi-pause'
                                                "
                                                :color="
                                                    store.validNewTask != null
                                                        ? store.validNewTask
                                                            ? 'success'
                                                            : 'error'
                                                        : 'info'
                                                "
                                                size="x-small"
                                                disabled
                                            ></v-btn>
                                        </template>
                                    </v-text-field>
                                    <v-card-actions
                                        class="d-flex justify-end"
                                        v-if="store.validNewTask != null"
                                    >
                                        <v-btn
                                            variant="outlined"
                                            @click="
                                                store.cancelAddTask(
                                                    index,
                                                    elIndex
                                                )
                                            "
                                        >
                                            <v-icon icon="mdi-close"></v-icon>
                                            <v-tooltip
                                                activator="parent"
                                                location="bottom"
                                                >Cancel</v-tooltip
                                            >
                                        </v-btn>
                                        <v-btn
                                            variant="outlined"
                                            @click="
                                                store.saveNewTask(
                                                    index,
                                                    elIndex,
                                                    element
                                                )
                                            "
                                        >
                                            <v-icon icon="mdi-check"></v-icon>
                                            <v-tooltip
                                                activator="parent"
                                                location="bottom"
                                                >Save</v-tooltip
                                            >
                                        </v-btn>
                                    </v-card-actions>
                                </v-card-text>
                            </v-card>
                        </v-sheet>
                    </template>
                </draggable>
            </v-card-text>
        </v-card>
    </v-sheet>
</template>
<script lang="ts" name="page_group_index" setup>
import { dateTimeFormatter } from "@/src/helpers/formatter.ts";
import { useGroupStore } from "@/src/stores/group.js";
import { ref } from "vue";
import draggable from "vuedraggable";

const store = useGroupStore();
const drag = ref(false);

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
</script>
