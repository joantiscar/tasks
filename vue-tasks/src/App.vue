<template>
    <div id="app">
        <tasks :tasks="tasks"></tasks>
    </div>
</template>

<script>
    import Tasks from './components/Tasks.vue'
    import axios from 'axios'

    export default {
        name: 'app',
        data() {
            return {
                tasks: []
            }
        },
        components: {
            'tasks': Tasks
        },
        async created() {
            console.log('El component ha estat creat')
            // AJAX -> Asynchronous JAvascript i XML
            // XHR -> XMLHTTPRequest

            // JAVASCRIPT NO BLOQUEJA, ES ASINCRONITZAT
            // axios.get('http://localhost:8050/api/v1/tasks')
            // console.log('PROVA');

            //3 opcions

            // // 1)CALLBACKS -> Funcions anonimes
            // // let file = fileManager.open('/home/dios/.bashrc')
            // // console.log(file)
            // let file = fileManager.open('/home/dios/.bashrc', () => {
            //     console.log(file)
            // })


            // 2) PROMISES then.catch
            // axios.get('http://httpbin.org/get').then(() => {
            axios.get('http://localhost:8050/api/v1/tasks').then(() => {
                console.log('TOT HA ANAT BE')
            }).catch(() => {
                console.log('ERROR')
            })

            // // 3) ASYNC WAIT
            // async function () {
            //     let result = await axios.get('http://localhost:8050/api/v1/tasks')
            // }


            // axios.get('http://localhost:8050/api/v1/tasks')

            // 3 opcions
            // 1) API per defecte de Javascript: https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
            // 2) Jquery --> Ajax/XHR
            // 3) Llibreria específica -> Axios
        }
    }
</script>

<style>
    /*#app {*/
    /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
    /*-webkit-font-smoothing: antialiased;*/
    /*-moz-osx-font-smoothing: grayscale;*/
    /*text-align: center;*/
    /*color: #2c3e50;*/
    /*margin-top: 60px;*/
    /*}*/
</style>
