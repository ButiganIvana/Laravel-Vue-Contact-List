<template>
  <div>
    <search-component @searchContacts="contactsHandler" :favourite="true" />
    <div class="contacts">
        <div class="no-favorites" v-show="this.contacts.length == 0">No favorites.</div>
      <contact-component
      @refreshContacts="refreshContactsHandler"
      :contacts="this.contacts"/>
    </div>
  </div>
</template>

<script>
import ContactComponent from "./ContactComponent";
import SearchComponent from "./../common/SearchComponent";
export default {
  components: {
    ContactComponent,
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
          let contacts = response.data.data
          const onlyFavorites = contacts.filter(contact => contact.favourite === 1);

          this.contacts = onlyFavorites;
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

.no-favorites {
    text-align: center;
    font-size: 20px;
    width: 100%;
}
</style>
