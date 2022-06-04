<template>
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <router-link :to="{ name: 'account.profile' }" class="nav-link" active-class="active" exact>Profile</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'account.password' }" class="nav-link" active-class="active" exact>Change Password</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'account.social' }" class="nav-link " active-class="active" exact>Social Link</router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        methods: {

        },
    }
</script>

<style scoped>
    .card-header-tabs .nav-link.active {
        background-color: #e3f2fd;
        border-bottom-color: #e3f2fd;
    }

    li > .nav-link {
        color: #fff;
    }
    
    li > .active {
        color: var(--bs-dark); 
    }
</style>