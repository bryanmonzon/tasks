<template>
    <div class="col-md-4 mb-sm-4">
        <div class="card card-default">
            <div class="card-header">New Task</div>
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <input class="form-control" 
                            type="text" 
                            v-model="form.body" 
                            :class="{'is-invalid': this.form.errors.has('body') }"
                            placeholder="What's your task?"
                        >
                        <div class="invalid-feedback" v-show="form.errors.has('body')">
                            {{ form.errors.get('body') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" 
                            type="number"
                            v-model="form.hours"
                            :class="{'is-invalid': this.form.errors.has('hours') }"
                            placeholder="Number of Hours"
                        >
                        <div class="invalid-feedback" v-show="form.errors.has('hours')">
                            {{ form.errors.get('hours') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <!-- <input type="text" class="form-control" value="June 12, 2018"> -->
                            <flat-pickr
                                    v-model="form.due_date"
                                    :config="config"                                          
                                    class="form-control due-date" 
                                    placeholder="Due Date"
                            >
                            </flat-pickr>
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" title="Toggle" data-toggle>
                                <i class="fa fa-calendar">
                                  <span aria-hidden="true" class="sr-only">Toggle</span>
                                </i>
                              </button>
                              <button class="btn btn-outline-secondary" type="button" title="Clear" data-clear>
                                <i class="fa fa-times">
                                  <span aria-hidden="true" class="sr-only">Clear</span>
                                </i>               
                              </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <select class="form-control" v-model="form.user">
                            <option value="" disabled>Assign a user (leave blank to set yourself)</option>
                            <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" v-model="form.project">
                            <option value="" disabled>Assign a project</option>
                            <option v-for="project in projects" :key="project.id" :value="project.id">{{project.name}}</option>
                        </select>
                    </div>

                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        components: {
          flatPickr
        },
        data() {
            return {
                projects: [],
                users: [],
                form: new Form({
                    body: '',
                    hours: 1,
                    due_date: '',
                    project: '',
                    user: ''
                }),
                config: {
                  wrap: true, // set wrap to true only when using 'input-group'
                  altFormat: 'M j, Y H:i:S',
                  altInput: true,
                  enableTime: true,
                  dateFormat: 'Y-m-d H:i:S',
                },
            }
        },
        created() {
            this.fetchProjects()
            this.fetchUsers()
        },
        methods: {
            fetchUsers() {
                axios.get('/api/users?sort=name')
                    .then(res => {
                        this.users = res.data.data
                    })
            },
            fetchProjects() {
                axios.get('/api/projects')
                    .then(res => {
                        this.projects = res.data.data
                    })
            },
            submit() {
                Tasks.post('/api/tasks', this.form)
                    .then(res => {
                        this.form.body = ''
                        this.form.hours = ''
                        this.form.due_date = ''
                        this.form.user = ''
                        this.form.project = ''

                        Bus.$emit('task:added', res.data)

                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
    }
</script>

<style lang="scss">
    input.due-date.form-control[readonly] {
        background: transparent;
    }
</style>