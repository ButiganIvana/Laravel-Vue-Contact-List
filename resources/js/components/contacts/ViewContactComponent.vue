<template>
  <div>
    <div class="card">
      <modal-component
        @close="closeModalHandler"
        :showModal="showModal"
        :myText="['Are you sure you want to delete this contact?']"
        :confirmAction="deleteContact"
        :confirmModal="true"
      />

      <div class="card-body">
        <div class="form-group" style="display: flex;justify-content: center;">
            <favourite-contact-button-component @isFavourited="checkIfFavourited" :favourite="this.data.favourite" :contact="this.data.id"/>
          <img class="upload-btn-wrapper" :src="this.data.profile_photo">
        </div>

        <div class="form-group">
          <h3>{{this.data.first_name}} {{this.data.last_name}}</h3>
        </div>

        <div class="form-group">
          <label for="email">{{this.data.email}}</label>
        </div>

        <div class="form-group">
          <h3>Numbers</h3>

          <view-numbers-component v-bind:phones="this.data.phones"/>
        </div>
      </div>

      <action-buttons-component @action="actionButtonHandler" :actionButtons="actionButtons"/>

    </div>
  </div>
</template>

<script>
import ViewNumbersComponent from "./ViewNumbersComponent";
import ModalComponent from "../common/ModalComponent";
import ActionButtonsComponent from "./../common/ActionButtonsComponent";
import FavouriteContactButtonComponent from "./buttons/FavouriteContactButtonComponent.vue";

export default {
  data: function() {
    return {
      image: "",
      data: [],
      showModal: false,
      actionButtons: [
        {
          class: "btn btn-light btn-submit",
          action: "backToContacts",
          name: "Back",
          icon: ""
        },
        {
          class: "btn btn-primary btn-submit",
          action: "gotoEditContact",
          name: "Edit",
          icon: "fa fa-pencil-square-o"
        }
      ]
    };
  },
  components: {
    ViewNumbersComponent,
    ModalComponent,
    ActionButtonsComponent,
    FavouriteContactButtonComponent
  },
  props: {
    id: {
      required: true
    }
  },

  mounted: function() {
    var q = this.$route.params.id;

    axios.get("/contact/" + q).then(response => {
      if (response.data.status === "success") {
        this.data = response.data.data[0];

        if(this.data.profile_photo == "") {
            this.data.profile_photo = "/images/user.png";
        }
      }
    });
  },
  methods: {
    closeModalHandler(value) {
      this.showModal = value;
    },
    checkIfFavourited(value) {
        this.data.favourite = !this.data.favourite;
    },
    backToContacts() {
      history.back();
    },

    actionButtonHandler(value) {
      switch (value) {
        case "backToContacts":
          return this.backToContacts();
        case "gotoEditContact":
          return this.gotoEditContact();
      }
    },

    showConfirmation: function(e) {
      e.preventDefault();
      this.showModal = true;
    },
    deleteContact: function(e) {
      e.preventDefault();
      var q = this.$route.params.id;
      axios.delete("/contact/" + q).then(response => {});
      history.back();
    },
    gotoEditContact() {
      this.$router.push({ path: `/contact/${this.data.id}/edit` });
    }
  }
};
</script>

<style scoped>
.card-body {
  text-align: center;
}
a {
  color: white !important;
  cursor: pointer;
}
input[type="file"] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  cursor: pointer;
}

.btn2 {
  border: none;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
  width: 200px;
  height: 200px;
}

.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
  border: 2px solid gray;
  color: gray;
  background-color: white;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
  width: 200px;
  height: 200px;
}

a,
a:hover {
  color: white;
  text-decoration: none;
}

.btn-custom {
  width: 100%;
  border-radius: 0;
}

.favorite {
  position: relative;
  right: 25px;
  top: 5px;
  font-size: 20px;
}
</style>
