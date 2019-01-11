<script>

export default {
  el: '#app',
  data: () => ({
    title: 'Lo pantano és de La Sénia',
    drawer: (window.localStorage.getItem('DRAWER_STATE_KEY') === 'true'),
    drawerRight: (window.localStorage.getItem('DRAWER_RIGHT_STATE_KEY') === 'true'),
    dark: (window.localStorage.getItem('DARK_THEME_KEY') === 'true'),

    items: [
      { icon: 'contacts', text: 'Welcome', url: '/' },
      { icon: 'history', text: 'About', url: '/about' },
      { icon: 'history', text: 'Contact', url: '/contact' },
      {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Tasques',
        model: true,
        children: [
          { icon: 'build', text: 'Tasques amb PHP', url: '/tasks' },
          { icon: 'build', text: 'Tasques amb tailwind', url: '/tasks_vue' },
          { icon: 'build', text: 'Tasques', url: '/tasques' },
          { icon: 'build', text: 'User Tasques', url: '/user/tasks' }

        ]
      },
      { icon: 'history', text: 'Tags', url: '/tags' }

    ],
    loginForm: false,
    registerForm: false
  }),
  props: {
    source: String
  },
  watch: {
    dark (newValue) {
      window.localStorage.setItem('DARK_THEME_KEY', newValue)
    },
    drawer (newValue) {
      window.localStorage.setItem('DRAWER_STATE_KEY', newValue)
    },
    drawerRight (newValue) {
      window.localStorage.setItem('DRAWER_RIGHT_STATE_KEY', newValue)
    }
  }
}
</script>
