<template>
  <div>
    <nav class="navbar navbar-light bg-light">
      <span class="navbar-brand" href="">Contacts</span>

      <a v-if="isAuthenticated" class="navbar-brand" href="#" @click="onLogoutHandler">Logout</a>
    </nav>

    <div v-if="!isAuthenticated">
      <div class="my-navbar">
        <router-link to="/login">
            Login
        </router-link>

        <router-link to="/register">
            Register
        </router-link>
      </div>
    </div>

    <div v-else>
      <div class="my-navbar">
        <router-link to="/contacts">
          <a>All Contacts</a>
        </router-link>

        <router-link to="/favorites">
          <a>My Favorites</a>
        </router-link>
      </div>
    </div>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>

import SearchComponent from "./common/SearchComponent";
import { mapActions, mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters(["getToken"]),

    isAuthenticated() {
      return this.getToken ? true : false;
    }
  },

  components: {
    SearchComponent,
  },

  methods: {
    ...mapActions(["setToken"]),

    onLogoutHandler: function() {
      this.$router.push("/login");
      localStorage.removeItem("token");
      this.setToken("");
    }
  }
};
</script>

<style>
.my-navbar {
  background-color: #3490dc;
  text-align: center;
  padding: 20px;
  font-size: 20px;
}

.my-navbar a {
  color: white;
  padding-right: 10px;
}

.container {
  padding-top: 20px;
}

.router-link-exact-active,
.router-link-active,
a:hover {
    text-decoration: underline;
}
</style>
