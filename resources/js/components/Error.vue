<template>
    <div v-if="errors" class="bg-danger text-white">
        <div class="col-md-12 pt-2 position-relative">
            <p class="position-absolute text-dark border-1 right-0 cursor-pointer" style="right: -10px;top: -20px; cursor:pointer;" @click="errors = ''" aria-hidden="true">
                X
            </p>
        </div>
        <ul class="pb-2">
            <li class="text-white" v-for="(e,index) in errors" :key="index"> {{ e }} </li>
        </ul>
    </div>
</template>
<script>
export default {
    name:'Error',
    props:{
        errors:''
    }
}
</script>
