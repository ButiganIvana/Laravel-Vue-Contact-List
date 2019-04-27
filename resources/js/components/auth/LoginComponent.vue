<template>
  <div>
    <div class="alert alert-primary" role="alert" v-show="errors">{{errors}}</div>

        <h3>Login</h3>
    <div class="card">

        <div class="form-group">
          <label for="inputEmail">Email address</label>
          <input type="email" class="form-control" placeholder="Enter email" v-model="email">
        </div>

        <div class="form-group">
          <label for="InputPassword1">Password</label>
          <input type="password" class="form-control" placeholder="Password" v-model="password">
        </div>

        <button type="submit" class="btn btn-primary btn-custom" @click="loginHandler">Submit</button>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      email: "",
      password: "",
      errors: ""
    };
  },
  methods: {

    ...mapActions(['setToken']),

    loginHandler(e) {
      e.preventDefault();
      var login = {
        email: this.email,
        password: this.password
      };

      axios
        .post("/login", login)
        .then(res => {
          if (res.data.status == "error") {
            this.errors = res.data.data;
          } else {

              this.setToken(res.data.data.api_token);
              localStorage.setItem('token', res.data.data.api_token);
              this.$router.push('/contacts')

              window.axios.defaults.headers.common["Authorization"] =
              "Bearer " + localStorage.getItem("token");

          }
        })
    }
  }
};
</script>

<style scoped>
.card {
  margin: 3% auto;
  max-width: 30rem;
}

.btn-custom {
  width: 100%;
  border-radius: 0;
}

.form-group {
  padding-left: 20px;
  padding-right: 20px;
  padding-bottom: 0px;
  padding-top: 10px;
}
h3 {
    text-align: center;
}
</style>
