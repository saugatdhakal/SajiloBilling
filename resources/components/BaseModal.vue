<template>
  <div
    class="modal fade"
    :id="modelId"
    data-bs-backdrop="static"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
    v-show="props.modelToggle"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5
            v-if="props.modelHeader"
            class="modal-title"
            id="exampleModalLabel"
          >
            {{ props.modelHeader }}
          </h5>
          <button
            @click="$emit('closeForm')"
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form>
          <div class="modal-body">
            <slot name="modalBody"> </slot>
          </div>
          <div class="modal-footer">
            <button
              @click="$emit('closeForm')"
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelId: {
    type: String,
    define: "",
  },
  modelHeader: {
    type: String,
    define: "",
  },
  modelToggle: {
    required: true,
  },
});
</script>

<style>
</style>
