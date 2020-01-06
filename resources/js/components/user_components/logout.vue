<template>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { }
        },
        methods: {
            logout() {
                console.log(this.user);
                axios
                    .post("api/logout")
                    .then(response => {
                        console.log(response);
                        
                        this.$root.deleteToken();
                        this.$router.push( 'welcome' )
                    });
            }
        },
        mounted() {
            this.logout();
        }
    }
</script>