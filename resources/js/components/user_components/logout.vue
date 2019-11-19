<template>
    <div class="jumbotron">        
    </div>
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
                        window.axios.defaults.headers.common['Authorization'] = '';
                        
                        this.$root.isLogged = false;                                 
                        this.$router.push( 'welcome' )
                    });
            }
        },
        mounted() {
            console.log('cenas');
            this.logout();
        }
    }
</script>