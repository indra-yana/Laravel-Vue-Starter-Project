<template>
  <div>
      <MainNavigation />

      <div class="container mt-5">
        <router-view/>
      </div>
  </div>
</template>

<script>
  import MainNavigation from './MainNavigation.vue'
  
  export default {
    components: {
      MainNavigation
    }  
  };
</script>