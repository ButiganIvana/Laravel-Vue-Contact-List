<template>
  <div style="display:contents">
    <div v-for="contact in this.allContacts" :key="contact.id">
      <div class="card">
        <div class="btn-menu">
          <favourite-contact-button-component
          @isFavourited="checkIfFavourited"
          :favourite="contact.favourite" :contact="contact.id"/>
          <router-link :to="`/contact/${contact.id}/edit`" data-toggle="tooltip" title="Edit contact" >
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          </router-link>
          <delete-contact-button-component @refreshContacts="refreshContactsHandler" :contact="contact.id"/>
        </div>


          <router-link :to="`/contact/${contact.id}/view`">
          <div class="contact-image">
            <img :src="contact.profile_photo == '' ? '/images/user.png' : contact.profile_photo ">
             </div>
          </router-link>


        <h5 class="card-title">{{ contact.first_name }} {{ contact.last_name }}</h5>
      </div>
    </div>
  </div>
</template>

<script>
import FavouriteContactButtonComponent from "./buttons/FavouriteContactButtonComponent.vue";
import DeleteContactButtonComponent from "./buttons/DeleteContactButtonComponent.vue";

export default {
  components: {
    FavouriteContactButtonComponent,
    DeleteContactButtonComponent
  },
  props: ["contacts"],
  data: function() {
      return {
          data: this.contacts
      }
  },

  computed: {
      allContacts: {
          get() { return this.contacts},
          set(value) { return value}
      }
  },
  methods: {
      refreshContactsHandler(value) {
          this.$emit("refreshContacts", value);
      },

      checkIfFavourited(value) {
        this.contacts.map((contact)=> {
            if (contact.id == value) {
                contact.favourite = !contact.favourite
            }
        })
    },
  }
};
</script>


<style scoped>
.btn-menu {
  display: flex;
  width: 100%;
  height: 40px;
  justify-content: center;
}
.btn-menu a {
  color: black;
  top: 5px;
  position: absolute;
  font-size: 17px;
}

.contact-image img {
  width: 100%;
}

.contact-image {
  width: 300px;
  height: 300px;
  overflow: hidden;
  border-radius: 0px;
}
.btn-custom {
  border-radius: 0;
  width: 100%;
}

.card {
  width: 18rem;
  margin-bottom: 20px;
  overflow: hidden;
}
.card-title {
  text-align: center;
  margin-top: 10px;
}
</style>
