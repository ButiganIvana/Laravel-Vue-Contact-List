<template>
  <div @click="this.toggleFavourite" class="favourite"  data-toggle="tooltip" title="Favourite contact">
    <i class="fa" v-bind:class="[this.isFavourite ? 'fa-star' : 'fa-star-o']"></i>
  </div>
</template>

<script>
export default {
  props: ["favourite", "contact"],

  computed: {
      isFavourite: {
          get() { return this.favourite },
          set (value) { this.$emit('isFavorited', value)
          }
      }
  },
  methods: {
    toggleFavourite() {

      axios.post("/contact/favourite/" + this.contact).then(response => {
        if (response.data.status === "success") {
          this.isFavourite = !this.isFavourite;
          this.$emit('isFavourited', this.contact)

        }
      });
    }
  },
};
</script>

<style>
.favourite {
  display: flex;
  top: 10px;
  position: absolute;
  right: 10px;
  font-size: 18px;
  cursor: pointer;
}
</style>
