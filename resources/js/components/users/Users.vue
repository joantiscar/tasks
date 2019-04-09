<template>
<users-list :users="users"></users-list>
</template>

<script>
  import UsersList from './UsersList'
  export default {
    name: "Users",
    components: {UsersList},
    props: {
      users: {
        type: Array,
        required: true
      }
    }
  }
</script>

<style scoped>

</style>
