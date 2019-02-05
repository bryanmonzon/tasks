<template>
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span>{{tasks.length}} {{ pluralize('Task', tasks.length) }}</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary" @click="fetchMyTasks">My Tasks</button>
                    <button type="button" class="btn btn-link"@click="fetchTasks">Reset</button>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-link" @click="fetchCompletedTasks">Completed</button>
                <button type="button" class="btn btn-link" @click="fetchIncompletedTasks">Incomplete</button>

                <select v-model="selectedUser" @change="filterUser">
                    <option value="">All Users</option>
                    <option v-for="user in users" :value="user">{{user.name}}</option>
                </select>

                <select v-model="selectedProject" @change="filterProject">
                    <option value="">All Projects</option>
                    <option v-for="project in projects" :value="project">{{project.name}}</option>
                </select>
            </div>
            <div class="table-responsive" v-if="tasks.length > 0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Done</th>
                            <th>Due</th>
                            <th>{{tasks.length}} {{ pluralize('Task', tasks.length) }}</th>
                            <th>Assigned</th>
                            <th>Project</th>
                            <th>{{ sumTasksHours.hours }} Hours</th>
                            <th>Client Reviewed</th>
                            <th>Client Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        <task-item v-for="task in tasks" :task="task" :key="task.id" />
                    </tbody>
                </table>
            </div>
            <div class="card-body" v-else>
                <div class="alert alert-info">
                    <p>No tasks</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import queryString from 'query-string'
    import TaskItem from './TaskItem'

    export default {
        components: {
            TaskItem,
        },
        data() {
            return {
                tasks: [],
                totalTasks: '',
                users: [],
                selectedUser: '',
                projects: [],
                selectedProject: ''
            }
        },
        created() {
            var self = this
            this.fetchTasks()

            Bus.$on('task:added', function(task) {
                self.tasks.unshift(task)
            })

            this.fetchUsers()
            this.fetchProjects()
        },
        computed: {
            sumTasksHours() {
                return this.tasks.reduce((a, b) => ({hours: a.hours + b.hours}));
            },
        },
        methods: {
            fetchUsers() {
                axios.get('/api/users?sort=name')
                    .then(res => {
                        this.users = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            fetchProjects() {
                axios.get('/api/projects?sort=name')
                    .then(res => {
                        this.projects = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            filterUser() {

                if( !this.selectedUser ) {
                    this.fetchTasks()
                }else {
                    axios.get(`/api/tasks?include=user,project&filter[user_id]=${this.selectedUser.id}`)
                            .then(res => {
                                this.tasks = res.data.data
                            })
                            .catch(err => {
                                console.log(err)
                            })
                }
            },
            filterProject() {

                if( !this.selectedProject ) {
                    this.fetchTasks()
                }else {
                    
                    axios.get(`/api/tasks?include=user,project&filter[project_id]=${this.selectedProject.id}`)
                        .then(res => {
                            this.tasks = res.data.data
                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
            },
            fetchMyTasks() {
                axios.get(`/api/tasks?include=user,project&filter[user_id]=${user.id}`)
                    .then(res => {
                        this.tasks = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            fetchTasks() {
                axios.get(`/api/tasks?include=user,project`)
                    .then( res => {
                        this.tasks = res.data.data
                    })
                    .catch( err => {
                        console.log(err)
                    })
            },
            fetchCompletedTasks() {
                axios.get(`/api/tasks?include=user,project&filter[completed]=1`)
                    .then( res => {
                        this.tasks = res.data.data
                    })
                    .catch( err => {
                        console.log(err)
                    })
            },
            fetchIncompletedTasks() {
                axios.get(`/api/tasks?include=user,project&filter[completed]=0`)
                    .then( res => {
                        this.tasks = res.data.data
                    })
                    .catch( err => {
                        console.log(err)
                    })
            },
        }
    }
</script>