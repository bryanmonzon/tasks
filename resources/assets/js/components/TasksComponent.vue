<template>
    <div class="container-fluid">
        <div class="row justify-content-center mb-4">
            <task-form />
            <tasks-list />
        </div>

    </div>
</template>

<script>
    import TaskForm from './TaskForm'
    import TasksList from './TasksList'
    export default {
        components: {
            TaskForm,
            TasksList,
        },
        data() {
            return {

            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
