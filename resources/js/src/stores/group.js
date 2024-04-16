import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import Swal from "sweetalert2";

export const useGroupStore = defineStore("group", () => {
    const groups = ref([]);
    const taskLoading = ref();
    const groupLoading = ref();
    const itemEditBefore = ref();

    const editedGroup = ref();
    const validNewTask = ref();
    const foundTask = ref([]);
    const detailViewed = ref(false);

    let timeout = 0;

    function changeColor(color, id) {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const url = route("group.update", id);

            axios
                .put(url, {
                    color: color,
                })
                .then(() => {})
                .catch((error) => {
                    console.log(error);
                });
        }, 2000);
    }

    async function addGroup() {
        const { value: title } = await Swal.fire({
            title: "Column Title",
            input: "text",
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return "You need to write something!";
                }
            },
        });

        if (title) {
            const url = route("group.store");
            axios
                .post(url, {
                    title: title,
                })
                .then(({ data }) => {
                    groups.value.splice(groups.value.length - 1, 0, {
                        id: data.data.id,
                        title: data.data.title,
                        color: data.data.color,
                        for_complete: data.data.for_complete,
                        is_default: data.data.is_default,
                        created_at: data.data.created_at,
                        updated_at: data.data.updated_at,
                        tasks: [],
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

    function saveEditGroup(groupIndex, value) {
        const url = route("group.update", value.id);
        groupLoading.value = groupIndex;

        axios
            .put(url, {
                title: value.title,
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                groupLoading.value = null;
                editedGroup.value = null;
            });
    }

    function cancelEditGroup(groupIndex) {
        groups.value[groupIndex].title = itemEditBefore.value.title;
        editedGroup.value = null;
    }

    function deleteGroup(id, groupIndex) {
        groupLoading.value = groupIndex;

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                const url = route("group.destroy", id);

                axios
                    .delete(url)
                    .then(() => {
                        groups.value.splice(groupIndex, 1);
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => {
                        groupLoading.value = null;
                    });
            }
        });
    }

    function addTask(groupIndex) {
        groups.value[groupIndex].tasks.unshift({
            id: null,
            name: "",
            completed: false,
            group_id: groups.value[groupIndex].id,
        });
    }

    function checkExistTask (value) {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            taskLoading.value = 'new';
            const url = route('task.findByName', { name: value });

            axios
                .get(url)
                .then(({ data }) => {
                    validNewTask.value = data.length == 0;
                    foundTask.value = data;
                })
                .catch((error) => {
                    console.log(error);
                }).finally(() => {
                    taskLoading.value = null;
                });
        }, 2000);
    }

    function saveNewTask(groupIndex, taskIndex, value) {
        const url = route("task.store");
        groupLoading.value = groupIndex;

        axios
            .post(url, {
                name: value.name,
                group_id: groups.value[groupIndex].id,
            })
            .then(({ data }) => {
                if (data.success) {
                    groups.value[groupIndex].tasks[taskIndex].id = data.data.id;
                    groups.value[groupIndex].tasks[taskIndex].name =
                        data.data.name;
                    groups.value[groupIndex].tasks[taskIndex].completed =
                        data.data.completed;
                    groups.value[groupIndex].tasks[taskIndex].group_id =
                        data.data.group_id;
                    groups.value[groupIndex].tasks[taskIndex].created_at =
                        data.data.created_at;
                }
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                groupLoading.value = null;
            });
    }

    function cancelAddTask(groupIndex, taskIndex) {
        groups.value[groupIndex].tasks.splice(taskIndex, 1);
    }

    function completeTask(value, id, groupIndex, taskIndex) {
        const url = route("task.update", id);
        taskLoading.value = id;

        axios
            .put(url, {
                completed: value == 1,
            })
            .then(() => {
                if (value == 1 || value) {
                    groups.value[groups.value.length - 1].tasks.push(
                        groups.value[groupIndex].tasks[taskIndex]
                    );
                    cancelAddTask(groupIndex, taskIndex);
                } else {
                    groups.value[0].tasks.push(
                        groups.value[groupIndex].tasks[taskIndex]
                    );
                    cancelAddTask(groupIndex, taskIndex);
                }
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                taskLoading.value = null;
            });
    }

    function deleteTask(id, taskIndex, groupIndex) {
        const url = route("task.destroy", id);
        groupLoading.value = groupIndex;

        axios
            .delete(url)
            .then(() => {
                cancelAddTask(groupIndex, taskIndex);
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                groupLoading.value = null;
            });
    }

    return {
        changeColor,
        addGroup,
        saveEditGroup,
        editedGroup,
        addTask,
        checkExistTask,
        saveNewTask,
        cancelAddTask,
        completeTask,
        deleteTask,
        groups,
        taskLoading,
        groupLoading,
        itemEditBefore,
        cancelEditGroup,
        deleteGroup,
        validNewTask,
        foundTask,
        detailViewed,
    };
});
