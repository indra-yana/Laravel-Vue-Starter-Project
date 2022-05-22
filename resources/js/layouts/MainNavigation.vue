<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark bg-gradient shadow-sm">
        <div class="container">
            <router-link to="/" class="navbar-brand "><span class="fs-4">Laravue SPA</span></router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon "></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto" v-if="!isLoggedIn">
                    <!-- Unauthentication Links -->
                    <router-link :to="{ name: 'login'}" class="nav-item nav-link" active-class="active" exact>Login</router-link>
                    <router-link :to="{ name: 'register'}" class="nav-item nav-link" active-class="active" exact>Register</router-link>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><router-link :to="{ name: 'login'}" class="dropdown-item" active-class="active" exact>Login</router-link></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> -->
                </ul>
                <ul class="navbar-nav ms-auto" v-else>
                    <!-- Authentication Links -->
                    <router-link :to="{ name: 'dashboard'}" class="nav-item nav-link" active-class="active" exact>Dashboard</router-link>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle p-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle border border-1 border-secondary">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">{{ auth.user.name }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ auth.user.email }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" style="cursor: pointer;" @click="doLogout">Logout</a></li>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  </div>
</template>

<script>
    import { mapState } from 'pinia'
    import { authState } from '.././store/authState.js';
    
    export default {
        data() {
            return {
                currentRoute: this.$route.name,
            };
        },
        created() {

        },
        computed: { 
            ...mapState(authState, ['isLoggedIn', 'logout', 'auth'])
        },
        methods: {
            async doLogout() {
                await this.logout();
                await this.$router.push({name: 'login'});
            }
        }
    };
</script>