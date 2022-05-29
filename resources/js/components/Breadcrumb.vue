<template>
    <h3 class="text-white">{{ title }}</h3>
    <nav style="--bs-breadcrumb-divider: '&bull;';" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item" v-for="(breadcrumb, key, index) in breadcrumbs">
                <span class="breadcrumb-item active" aria-current="page" v-if="loopLast(index)"> {{ breadcrumb }}</span>
                <a :href="key" v-else>{{ breadcrumb }}</a>
            </li>
        </ol>
    </nav>
</template>

<script>
    export default {
        props: {
            title: {
                default: "Page Title"
            },
            breadcrumbs: {
                default: {
                    'menu1': 'Menu 1',
                    'menu2': 'Menu 2',
                    'menu3': 'Last Menu',
                }
            },
        },
        methods: {
            loopLast(index) {
                return index == Object.keys(this.breadcrumbs).length - 1;
            }
        },
    }
</script>