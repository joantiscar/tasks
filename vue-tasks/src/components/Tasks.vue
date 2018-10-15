<template>
    <div class="container flex justify-center font-sans">
        <div class="flex flex-col">
            <h1 class="text-center text-red-lighter">Tasques</h1>
            <div class="flex-row">

                <input type="text"
                       v-model="newTask" @keyup.enter="add"
                       class="m-3 mt-5 p-2 pl-5 shadow rounded focus:shadow-outline text-grey-darker">
                <v-btn color="success" @click="add">Afegir</v-btn>
                <!--<input :value="newTask" @input="newTask = $event.target.value">-->
            </div>
            <ul class="list-reset m-3 pl-5">
                <!--<li v-for="dataTask in dataTasks" v-if="dataTask.completed">{{dataTask.name}}</li>-->
                <!--<li v-else>{{dataTask.name}}</li>-->
                <li class="text-grey-darker" v-for="dataTask in filteredTasks" :key="dataTask.id"><span
                        :class="{ strike: dataTask.completed }">

                    <editable-text :text="dataTask.name"
                                   @edited="editName(dataTask, $event)">
<v-btn color="success" @click="editName">Afegir</v-btn>

                    </editable-text>

                </span>&nbsp;<span @click="remove(dataTask)">asdasdasds&#x274c;</span>


                </li>

            </ul>

            <h3>Filtres:</h3>
            <h5>Active filter: {{ filter }}</h5>
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
        all: function (dataTasks) {
            return dataTasks
        },
        completed: function (dataTasks) {
            return dataTasks.filter(function (dataTask) {
                // if (dataTasks.completed) return true
                // else return false
                return dataTasks.completed
            })
        },
        active: function (dataTasks) {
            return dataTasks.filter(function (dataTask) {
                // if (!dataTasks.completed) return true
                // else return false
                return !dataTasks.completed
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
                dataTasks: ''
            }
        },
        props: {
          'tasks': {
              type: Array,
              required: true
          }
        },
        computed: {
            filteredTasks() {
                return filters[this.filter](this.dataTasks)
            },
            total() {
                return this.dataTasks.length
            },
        },
    watch: {
        tasks(newTasks) {
                this.dataTasks = newTasks
            }
        },
            methods: {
            editName(dataTask, text){
                console.log('acho');
                dataTask.name= text
            },
            add() {
                this.dataTasks.splice(0, 0, {name: this.newTask, completed: false})
                this.newTask = ''
            },
            remove(dataTask) {
                window.console.log(dataTask)

                this.dataTasks.splice(this.dataTasks.indexOf(dataTask), 1)
            },
            setFilter(newFilter) {
                this.filter = newFilter
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