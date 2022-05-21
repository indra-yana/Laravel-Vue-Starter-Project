<template>
  <div>
      <AuthNavigation />

      <div class="container mt-5">
        <router-view/>
      </div>
  </div>
</template>

<script>
  import AuthNavigation from './AuthNavigation.vue'
  
  export default {
    components: {
      AuthNavigation
    }  
  };
</script>