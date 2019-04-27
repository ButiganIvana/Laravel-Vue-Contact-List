<template>
  <div class="card">
    <modal-component
      @close="closeModalHandler"
      :showModal="this.showModal"
      :myText="this.errors"
      :infoModal="true"
    />
    <contact-form-component :data="data" />
    <action-buttons-component @action="actionButtonHandler" :actionButtons="actionButtons"/>

  </div>
</template>

<script>
import AddNumbersComponent from "./AddNumbersComponent";
import ContactFormComponent from './contactFormComponent'
import ModalComponent from "../common/ModalComponent";
import ActionButtonsComponent from "./../common/ActionButtonsComponent";


export default {
  data: function() {
    return {
      data: {
        email: "",
        first_name: "",
        last_name: "",
        profile_photo: [],
        phones: []
      },
      showModal: false,
      errors: [],
      actionButtons: [
        {
          class: "btn btn-light btn-submit",
          action: "cancelAndBackHandler",
          name: "Cancel",
          icon: ""
        },
        {
          class: "btn btn-primary btn-submit",
          action: "createContactHandler",
          name: "Save",
          icon: ""
        }
      ]
    };
  },
  components: {
    AddNumbersComponent,
    ModalComponent,
    ContactFormComponent,
    ActionButtonsComponent
  },
  methods: {
    closeModalHandler(value) {
      this.showModal = value;
    },

    cancelAndBackHandler() {
      history.back();
    },

    actionButtonHandler(value) {
      switch (value) {
        case "cancelAndBackHandler":
          return this.cancelAndBackHandler();
        case "createContactHandler":
          return this.createContactHandler();
      }
    },

    createContactHandler() {

      axios.post("/contact/", this.data).then(response => {
        if (response.data.status === "success") {
          history.back();
        } else {
          this.errors = response.data.data;
          this.showModal = true;
        }
      });
    }
  }
};
</script>

<style>
.btn-submit {
  border-radius: 0;
  width: 100%;
}
</style>
