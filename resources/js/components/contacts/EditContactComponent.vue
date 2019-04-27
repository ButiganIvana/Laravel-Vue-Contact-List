<template>
  <div class="card">
    <modal-component
      @close="closeModalHandler"
      :showModal="showModal"
      :myText="errors"
      :infoModal="true"
    />

    <delete-contact-button-component :contact="contact.id"/>
    <contact-form-component :data="contact"/>
    <action-buttons-component @action="actionButtonHandler" :actionButtons="actionButtons"/>
  </div>
</template>

<script>
import AddNumbersComponent from "./AddNumbersComponent";
import ModalComponent from "./../common/ModalComponent";
import DeleteContactButtonComponent from "./buttons/DeleteContactButtonComponent";
import ContactFormComponent from "./contactFormComponent";
import ActionButtonsComponent from "./../common/ActionButtonsComponent";

export default {
  data: function() {
    return {
      contact: [],
      showModal: false,
      errors: [],
      actionButtons: [
        {
          class: "btn btn-light btn-submit",
          action: "backToEdit",
          name: "Back",
          icon: ""
        },
        {
          class: "btn btn-primary btn-submit",
          action: "submitEditContact",
          name: "Save",
          icon: ""
        }
      ]
    };
  },
  components: {
    AddNumbersComponent,
    ModalComponent,
    DeleteContactButtonComponent,
    ContactFormComponent,
    ActionButtonsComponent
  },
  methods: {
    closeModalHandler(value) {
      this.showModal = value;
    },

    actionButtonHandler(value) {
      switch (value) {
        case "backToEdit":
          return this.backToEdit();
        case "submitEditContact":
          return this.submitEditContact();
      }
    },

    backToEdit() {
      history.back();
    },

    submitEditContact() {
      var q = this.$route.params.id;

      axios.put("/contact/" + q, this.contact).then(response => {
        if (response.data.status === "success") {
          history.back();
        } else if (response.data.status !== "success") {
          this.errors = response.data.data;
          this.showModal = true;
        }
      });
    }
  },
  mounted: function() {
    var q = this.$route.params.id;

    axios.get("/contact/" + q).then(response => {
      if (response.data.status === "success") {
        this.contact = response.data.data[0];

        if (this.contact.profile_photo == "") {
            this.contact.profile_photo = [];
        }
      }
    });
  }
};
</script>

<style>
</style>
