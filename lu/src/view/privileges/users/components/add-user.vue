<template>
<div class="">

  <Modal v-model="modalShow" fullscreen title="Fullscreen Modal">
    <div>This is a fullscreen modal</div>
  </Modal>
</div>
</template>
<script>
export default {
  props: {
    modal: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      modalShow:false
    }
  },
  watch: {
    modal: function() {
      this.modalShow = true
    }
  }
}
</script>
