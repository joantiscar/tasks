<script>
export default {
    el: '#app',
    data: () => ({
        title: 'Lo pantano és de La Sénia',
        drawer: null,
        items: [
            { icon: 'contacts', text: 'Welcome', url: '/' },
            { icon: 'history', text: 'Home', url: '/about' },
            {
                icon: 'keyboard_arrow_up',
                'icon-alt': 'keyboard_arrow_down',
                text: 'Tasques',
                model: true,
                children: [
                    {icon: 'build', text:'Tasques amb PHP', url: 'tasks'},
                    {icon: 'build', text:'Tasques amb Vue', url: 'tasks_vue'}
                ]
            }
        ]
    }),
    props: {
        source: String
    }
}
</script>
