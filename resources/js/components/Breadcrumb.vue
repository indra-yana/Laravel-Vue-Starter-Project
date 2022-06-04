<template>
    <h3 class="text-white">{{ title }}</h3>
    <nav style="--bs-breadcrumb-divider: '&bull;';" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item" v-for="(breadcrumb, key, index) in breadcrumbs">
                <span class="breadcrumb-item active" aria-current="page" v-if="loopLast(index)"> {{ breadcrumb }}</span>
                <router-link :to="{ name: key }" v-else>{{ breadcrumb }}</router-link>
                <!-- <a :href="key" v-else>{{ breadcrumb }}</a> -->
            </li>
        </ol>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                title: "Page Title",
                breadcrumbs: {
                    'home': 'Menu 1',
                    'landing': 'Menu 2',
                    'menu3': 'Last Menu',
                },
            };
        },
        created() {
            // Generate dynamic breadcrumb from partial layout 
            this.$event.on('breadcrumbs', (e) => {
                this.title = e.title;
                this.breadcrumbs = e.breadcrumbs;
            });
        },
        methods: {
            loopLast(index) {
                return index == Object.keys(this.breadcrumbs).length - 1;
            }
        },
    }
</script>