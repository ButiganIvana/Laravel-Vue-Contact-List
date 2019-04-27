<template>
<div>
    <modal-component
        @close="closeModalHandler"
        :showModal="showModal"
        :myText="['Are you sure you want to delete this contact?']"
        :confirmAction="deleteContact"
        :confirmModal="true"
      />
  <div @click="this.openDialogHandler" class="delete"  data-toggle="tooltip" title="Delete contact">
    <i class="fa fa-trash"></i>
  </div>
  </div>
</template>

<script>

import ModalComponent from './../../common/ModalComponent';
export default {
  props: ["contact"],
  components: {
      ModalComponent
  },
data: function() {
    return {
        showModal:false,
    }
},

  methods: {

    openDialogHandler() {
        this.showModal = true;
    },

    closeModalHandler(value) {
        this.showModal = value;
    },
    deleteContact(e) {
      e.preventDefault();
      axios.delete("/contact/" + this.contact).then(response => {
          if (response.data.status == "success") {
               this.showModal = false;
               this.$emit('refreshContacts', response.data.data);
          }

      });
    }
  }
};
</script>

<style scoped>
.delete {
  display: flex;
  top: 10px;
  position: absolute;
  left: 10px;
  font-size: 18px;
  cursor: pointer;
}

</style>
