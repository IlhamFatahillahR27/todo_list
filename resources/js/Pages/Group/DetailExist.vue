<template>
    <v-dialog v-model="store.detailViewed" width="50%">
        <v-card
            prepend-icon="mdi-subtitles-outline"
            title="All Available Title"
        >
            <v-card-text>
                <template v-for="(item, index) in store.foundTask" :key="index">
                    <v-card :title="item.title" variant="tonal" class="mt-3">
                        <v-card-text class="d-flex ga-3 flex-wrap">
                            <template
                                v-for="(task_item, task_index) in item.tasks"
                                :key="task_index"
                            >
                                <v-card :title="task_item.name" :subtitle="dateTimeFormatter(task_item.created_at)">
                                </v-card>
                            </template>
                        </v-card-text>
                    </v-card>
                </template>
                <v-card-actions>
                    <v-btn
                        class="ms-auto"
                        size="x-large"
                        color="primary"
                        variant="tonal"
                        text="Ok"
                        @click="[store.detailViewed = false, store.foundTask = []]"
                    ></v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script lang="ts" setup name="page_group_detail_exist">
import { useGroupStore } from "@/src/stores/group.js";
import { dateTimeFormatter } from "@/src/helpers/formatter.ts";

const store = useGroupStore();
</script>
