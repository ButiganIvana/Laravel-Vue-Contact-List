<template>
  <div>
    <search-component @searchContacts="contactsHandler"/>
    <div class="contacts">
      <add-contact-button-component/>
      <contact-component
       @refreshContacts="refreshContactsHandler"
       :contacts="this.contacts"/>
    </div>
  </div>
</template>

<script>
import ContactComponent from "./ContactComponent";
import AddContactButtonComponent from "./buttons/AddContactButtonComponent";
import SearchComponent from "./../common/SearchComponent";
export default {
  components: {
    ContactComponent,
    AddContactButtonComponent,
    SearchComponent
  },

  data: function() {
    return {
      contacts: []
    };
  },
  methods: {
    contactsHandler: function(contacts) {
      this.contacts = contacts[0];
      if (contacts[1] == "") {
        this.findAllContacts();
      }
    },
    findAllContacts() {
      axios.get("/contact/").then(response => {
        if (response.data.status === "success") {
          this.contacts = response.data.data;
        }
      });
    },
    refreshContactsHandler(value) {

        this.findAllContacts();
    },
  },

  mounted() {
    this.findAllContacts();
  }
};
</script>

<style>
.contacts {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding-top: 20px;
}

.contacts::after {
  content: "";
  display: block;
  margin-left: 26%;
}
</style>
