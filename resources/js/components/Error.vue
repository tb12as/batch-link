<template>
  <div class="notification is-danger m-2">
    <!-- <button class="delete"></button> -->
    {{ message }}
  </div>
</template>

<script>
export default {
  props: {
    message: String
  },
};
</script>