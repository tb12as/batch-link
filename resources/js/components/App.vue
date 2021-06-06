<template>
  <div class="container">
    <Navbar />
    <router-view></router-view>
  </div>
</template>

<script>
import Navbar from './Navbar'
export default {
    components: {
        Navbar,
    },
    
    mounted() {
        document.title = 'Hello World'
    }
}
</script>