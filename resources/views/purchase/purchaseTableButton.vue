<template>
  <div class="btn-group" v-if="!props.softDeleteButton">
    <router-link
      class="btn btn-light"
      v-if="props.status =='RUNNING'"
      :to="{ name: 'purchaseItems', params: { id: props.id}}"
    >
        <i class="fa-light fa-file-invoice fa-lg"></i>
    </router-link>
    <router-link
      class="btn btn-primary"
      :to="{ name: 'purchaseEdit', params: { id: props.id } }"
    >
      <i class="fa-regular fa-pen-to-square fa-lg"></i>
    </router-link>
    <button
              style="width: 100%"
              type="button"
              @click="$emit('viewPurchase', props.id)"
              class="btn btn-success"
              data-bs-toggle="modal"
              data-bs-target="#showPurchaseDetails"
            >
              <i class="fa-regular fa-eye fa-lg"></i>
            </button>
    <button
      type="button"
      class="btn btn-danger"
      @click="$emit('softDelete', props.id)"
    >
      <i class="fa-regular fa-user-xmark fa-lg"></i>
    </button>
  </div>
  <div v-else>
    <div class="btn-group">
      <button
      type="button"
        style="width: 100%"
        class="btn btn-success"
        @click="$emit('restoreHandler', props.id)"
      >
        <i class="fa-solid fa-arrow-rotate-left"></i>
      </button>


      <button  type="button" style="width: 100%" class="btn btn-danger"
      @click="$emit('forceDeleteHandler', props.id)"
      >
        <i class="fa-regular fa-user-xmark fa-lg"></i>
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  id: {
    type: [String, Number],
    required: true,
  },
  softDeleteButton: {
    type: Boolean,
    required: false,
    default: false,
  },
  status:{
    type: [String],
    required:true,
  },
  purchase:{
    type:[Object],
    required:true
  }
});
</script>

<style>
</style>
