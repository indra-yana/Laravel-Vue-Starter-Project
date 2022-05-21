<template>
    <div>
        <DashboardNavigation/>

        <div class="container mt-5">
            <router-view/>
        </div>
  </div>
</template>

<script>
    import DashboardNavigation  from "./DashboardNavigation.vue";

    export default {
        components: {
            DashboardNavigation,
        }
    }
</script>