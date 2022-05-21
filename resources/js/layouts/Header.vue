<template>
  <div>
    <div class="text-center" style="margin: 20px 0px 20px 0px;">
        <a href="https://shouts.dev/" target="_blank">{{ title }}</a><br>
        <span class="text-secondary">Laravel SPA with Vue 3, Auth (Sanctum), CURD Example</span>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['title'],
        // data() {
        //     return {
        //         title: "",
        //     };
        // },
    };
</script>