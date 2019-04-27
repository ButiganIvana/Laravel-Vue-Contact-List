<template>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon">
        <i class="fa fa-search"></i>
      </span>
    </div>
    <input
      type="text"
      v-model="search"
      v-on:keyup="onChangeHandler"
      class="form-control"
      placeholder="search"
      aria-label="search"
      aria-describedby="basic-addon"
    >
  </div>
</template>


<script>
export default {
  props: ["favourite"],
  data: function() {
    return {
      search: ""
    };
  },

  computed: {
    isFavourite() {
      if (this.favourite) {
        return "1";
      }
      return "0";
    }
  },

  methods: {
    onChangeHandler: function() {
      axios
        .get(
          "/contact/search/" + this.search + "/favourite/" + this.isFavourite
        )
        .then(response => {
          if (response.data.status === "success") {
            this.$emit("searchContacts", [response.data.data, this.search]);
          }
        });
    }
  }
};
</script>
