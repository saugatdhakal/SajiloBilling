<template>
  <div class="btn-group" v-if="!props.softDeleteButton">
    <router-link
      class="btn btn-primary"
      style=""
      :to="{ name: 'productEdit', params: { id: props.id } }"
    >
      <i class="fa-regular fa-pen-to-square fa-lg"></i>
    </router-link>
    <button
      style=""
      class="btn btn-danger"
      @click="$emit('softDelete', props.id)"
    >
      <i class="fa-regular fa-user-xmark fa-lg"></i>
    </button>
  </div>
  <div v-else>
    <div class="btn-group">
      <button
        style="width: 100%"
        class="btn btn-success"
        @click="$emit('restoreHandler', props.id)"
      >
        <i class="fa-solid fa-arrow-rotate-left"></i>
      </button>

      <button style="width: 100%" class="btn btn-danger"
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
});
</script>

<style>
</style>
