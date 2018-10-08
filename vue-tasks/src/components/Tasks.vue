<template>
    <div class="container flex justify-center font-sans">
        <div class="flex flex-col">
            <h1 class="text-center text-red-lighter">Tasques</h1>
            <div class="flex-row">

                <input type="text"
                       v-model="newTask" @keyup.enter="add"
                       class="m-3 mt-5 p-2 pl-5 shadow rounded focus:shadow-outline text-grey-darker">
                <svg @click="add()" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"/>
                </svg>
                <!--<input :value="newTask" @input="newTask = $event.target.value">-->
            </div>
            <ul class="list-reset m-3 pl-5">
                <!--<li v-for="task in tasks" v-if="task.completed">{{task.name}}</li>-->
                <!--<li v-else>{{task.name}}</li>-->
                <li class="text-grey-darker" v-for="task in filteredTasks" :key="task.id"><span
                        :class="{ strike: task.completed }">

                    <editable-text :text="task.name"
                                   @edited="editName(task, $event)">


                    </editable-text>

                </span>&nbsp<span @click="remove(task)">&#x274c;</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
                    </svg>

                </li>
                {{ filter }}
            </ul>

            <h3>Filtres:</h3>
            <ul>
                <li class="list-reset">
                    <button @click="setFilter('all')">Totes</button>
                </li>
                <li class="list-reset">
                    <button @click="setFilter('completed')">Completades</button>
                </li>
                <li class="list-reset">
                    <button @click="setFilter('active')">Actives</button>
                </li>
            </ul>
            Total: {{total}}
        </div>
    </div>
</template>

<script>
    import EditableText from './EditableText.vue'

    var filters = {
        all: function (tasks) {
            return tasks
        },
        completed: function (tasks) {
            return tasks.filter(function (task) {
                // if (tasks.completed) return true
                // else return false
                return tasks.completed
            })
        },
        active: function (tasks) {
            return tasks.filter(function (task) {
                // if (!tasks.completed) return true
                // else return false
                return !tasks.completed
            })
        }
    }
    export default {
        components: {
            'editable-text': EditableText,
        },
        data() {
            return {
                filter: 'all', //all completed active
                newTask: '',
                tasks: [
                    {
                        id: 1,
                        name: 'comprar pa',
                        completed: false
                    },
                    {
                        id: 2,
                        name: 'comprar lejia',
                        completed: false
                    },
                    {
                        id: 3,
                        name: 'comprar llet',
                        completed: false
                    },

                    {
                        id: 4,
                        name: 'Estudiar php',
                        completed: true
                    },
                ]
            }
        },
        setFilter(newFilter) {
            this.filter = newFilter
        },

        computed: {
            filteredTasks() {
                return filters[this.filter](this.tasks)
            },
            total() {
                return this.tasks.length
            }
        },
        methods: {
            editName(task, text){
                console.log('acho');
                task.name= text
            },
            add() {
                this.tasks.splice(0, 0, {name: this.newTask, completed: false})
                this.newTask = ''
            },
            remove(task) {
                window.console.log(task)

                this.tasks.splice(this.tasks.indexOf(task), 1)
            }
        }
    }

    // CAR
    // {
    //     marca: 'Renault',
    //     consum: '51/100',
    //     start: function(){
    //     console.log('arranca');
    // }
    // }


</script>

<style>
    .strike {
        text-decoration: line-through;

    }

</style>