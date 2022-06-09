<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark bg-gradient shadow-sm fixed-top">
        <div class="container">
            <router-link to="/" class="navbar-brand "><span class="fs-4">Laravue SPA</span></router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon "></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto" v-if="isLoggedIn">
                    <router-link :to="{ name: 'dashboard' }" class="nav-item nav-link" active-class="active" exact>Dashboard</router-link>
                    <router-link :to="{ name: 'mypost' }" class="nav-item nav-link" active-class="active" exact>My Post</router-link>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" :class="{ 'active': isActive, 'show': isActive }" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" :aria-expanded="isActive">
                            Manage
                        </a>
                        <ul class="dropdown-menu" :class="{ 'show': isActive }" aria-labelledby="navbarDropdown">
                            <li><router-link :to="{ name: 'post' }" class="dropdown-item" active-class="active" exact>Post</router-link></li>
                            <li><router-link :to="{ name: 'account' }" class="dropdown-item" active-class="active" exact>Account</router-link></li>
                            <!-- <li><hr class="dropdown-divider"></li> -->
                            <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto" v-if="isLoggedIn">
                    <li class="nav-item me-3">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </li>
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle p-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <img :src="auth.user.avatar || '/images/user.png'" alt="avatar" width="32" height="32" class="rounded-circle border border-1 border-secondary">
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
    import { authState } from '.././src/store/authState.js';

    export default {
        data() {
            return {
                
            };
        },
        computed: { 
            ...mapState(authState, ['isLoggedIn', 'logout', 'auth']),
            isActive() {
                return [
                    'account.password',
                    'account.profile',
                    'account.social',
                    'post.index',
                    'post.create',
                    'post.update',
                ].includes(this.$route.name);
            },
        },
        methods: {
            async doLogout() {
                await this.$axios.post('/logout', { })
                    .then(({ data }) => {
                        this.logout();
                        this.$router.push({name: 'login'});
                    }).catch(({ response: { data } }) => {
                        console.log(data);
                    }).finally(() => {
                        
                    });
            },
            async getUser() {
                // Example test api
                await this.$axios.get("/api/user")
                        .then(response => {
                            const { data } = response;
                            console.log(data);

                            return data;
                        })
                        .catch(response => {
                            const { data } = response;

                            return data;
                        });
            }
        }
    };
</script>