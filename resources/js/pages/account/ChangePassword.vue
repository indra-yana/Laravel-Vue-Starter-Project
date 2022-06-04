<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-light rounded w-100">
                <div class="card-header bg-secondary bg-gradient border">
                    <NavAccount/>
                </div>
                <div class="card-body bg-primary-soft">
                    <h5 class="card-title">Change Password</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NavAccount from '../../components/NavAccount.vue';
    
    export default {
        components: { NavAccount },
        data() {
            return {
                routeName: this.$route.meta.title,
            };
        },
        created() {
            this.$event.emit("breadcrumbs", {
                title: this.routeName,
                breadcrumbs: {
                    "account": "Account",
                    "#": this.routeName,
                }
            });
        },
        methods: {},
}
</script>