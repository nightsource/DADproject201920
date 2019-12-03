<template>
<div class="col-md-4">
    <div class="box">
        <i class= "fa fa-eur fa-fw bg-primary"></i>
        <div class="info">
            <h3>{{value}}</h3> <span>{{valuesymbol}}</span>
            <p>{{desc}}</p>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['fa', 'value', 'type', 'valuesymbol', 'desc'],
}
</script>
