<template>
    <div class="welcome">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h2>Welcome to your Virtual Wallet, {{user.name}}</h2>
                        <p>O seu último acesso ao portal foi a {{user.updated_at}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],
    data: function () {
        return {
            
        }
    },
}
</script>

<style>
.welcome {
    color: #212121;
}

.welcome .content {
    background-color: #CECECE;
    padding: 15px;
    margin-top: 25px;
}

.welcome h2 {
    font-family: Calibri;
    font-weight: 100;
    margin-top: 0;
    font-size: 32px;
    font-weight: 500;
}

.welcome p {
    color: #212121;
}
</style>
