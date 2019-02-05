<template>
    <tr class="task-item" :class="{ 'completed bg-light': taskCompleted }">
        <td class="text-center align-middle">
            <i class="far fa-check-circle completed" 
                @click="toggleTask"
                v-if="taskCompleted"
            ></i>
            <i class="far fa-circle incomplete" 
                @click="toggleTask"
                v-else
            ></i>
        </td>
        <td><span v-if="task.due_date">{{task.due_date | dateshort }}</span></td>
        <td>{{task.body}}</td>
        <td>{{task.user.name}}</td>
        <td><span v-if="task.project">{{task.project.name}}</span></td>
        <td>{{task.hours}}</td>
        <td class="text-center align-middle">
            <i class="far fa-check-circle completed" 
                @click="toggleReviewed"
                v-if="clientReviewed"
            ></i>
            <i class="far fa-circle incomplete" 
                @click="toggleReviewed"
                v-else
            ></i>
        </td>
        <td class="text-center align-middle">
            <i class="far fa-check-circle completed" 
                @click="toggleApproved"
                v-if="clientApproved"
            ></i>
            <i class="far fa-circle incomplete" 
                @click="toggleApproved"
                v-else
            ></i>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['task'],
        data() {
            return {
                taskCompleted: this.task.completed,
                clientReviewed: this.task.client_reviewed,
                clientApproved: this.task.client_approved,
            }
        },
        methods: {
            toggleTask() {
                this.taskCompleted = !this.taskCompleted

                axios.patch(`/api/tasks/${this.task.id}`, {
                    completed: this.taskCompleted
                }).then(res => {
                    Bus.$emit('task:completed');
                }).catch(err => {
                    console.log(err)
                })
            },
            toggleReviewed() {
                this.clientReviewed = !this.clientReviewed

                axios.patch(`/api/tasks/${this.task.id}`, {
                    client_reviewed: this.clientReviewed
                }).then(res => {
                    Bus.$emit('task:reviewed');
                }).catch(err => {
                    console.log(err)
                })
            },
            toggleApproved() {
                this.clientApproved = !this.clientApproved

                axios.patch(`/api/tasks/${this.task.id}`, {
                    client_approved: this.clientApproved
                }).then(res => {
                    Bus.$emit('task:approved');
                }).catch(err => {
                    console.log(err)
                })
            },
            filterBy(type, id) {
                Bus.$emit('task:filtered', {
                    type: type,
                    id: id
                })
            }

        }
    }
</script>

<style lang="scss">
    tr.task-item{
        i {
            cursor: pointer;
            font-size: 24px;
        }

        i.incomplete {
            color:#6c757d;
        }
    }
    tr.task-item.completed {
        color:#6c757d;
        i.completed{
            color:#28a745 !important;
        }
    }
    
    i.incomplete {
        color:#6c757d;
    }
    i.completed{
        color:#28a745;
    }
</style>