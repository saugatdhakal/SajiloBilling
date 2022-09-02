<template>

<BaseDatePicker calenderType="English" v-model="date" />
</template>

<script>
import { ref } from '@vue/reactivity';
import BaseDatePicker from '../../components/BaseDatePicker.vue';
export default {
    components:{
        BaseDatePicker
    },
setup(){
const date = ref('');
return {date}
}

}
</script>

<style>

</style>
