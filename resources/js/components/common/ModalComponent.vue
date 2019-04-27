<template>
  <div class="modal" v-if="showModal">
    <div class="modal-wrapper">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p v-for="(text, index) in myText" :key="index">{{ Array.isArray(text) ? text[0] : text }}</p>
          </div>
          <div class="modal-footer" v-if="confirmModal">
            <button type="button" class="btn btn-secondary" @click="closeModalHandler">No</button>
            <button type="button" class="btn btn-primary" @click="confirmAction">Yes</button>
          </div>

          <div class="modal-footer" v-if="infoModal">
            <button type="button" class="btn btn-primary" @click="closeModalHandler">OK</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["showModal", "confirmModal", "infoModal", "confirmAction", "myText"],
  methods: {
    closeModalHandler: function() {
        this.$emit('close', false)
    }
  }
};
</script>

<style>
.modal {
  position: fixed;
  width: 100%;
  z-index: 2;
  display: flex;
  justify-content: center;
  padding-top: 100px;
}
</style>
