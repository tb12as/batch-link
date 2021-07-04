<template>
  <div>
    <Navbar />
    <div class="container content my-5">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from './Navbar'
export default {
    components: {
        Navbar,
    },
}
</script>