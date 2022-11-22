<template>
  <div
    class="modal fade"
    :id="modelId"
    v-bind="$attrs"
    :data-bs-backdrop="props.dropBack? '':'static'"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"

  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-black">
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
          <div class="modal-body text-black">
            <slot name="modalBody"> </slot>
          </div>
          <div class="modal-footer" v-if="props.footerButton">
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
  footerButton: {
    type: Boolean,
    default: true,
  },
  //Weather model should be close or not after clicking away
  dropBack:{
    type: Boolean,
    default:false,
  }
});
</script>

<style>
</style>
