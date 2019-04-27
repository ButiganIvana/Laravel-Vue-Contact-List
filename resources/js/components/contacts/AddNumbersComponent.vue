<template>
  <div>
    <div id="phoneNumbers">
      <div class="row" v-bind:data-counter="field.id" v-for="field in fields" v-bind:key="field.id">
        <div class="col-sm">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              name="label"
              placeholder="Enter Label"
              v-model="field.label"
            >
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <input
              type="tel"
              class="form-control"
              name="name"
              placeholder="Enter Phone"
              v-model="field.name"
            >
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <button type="button" @click="handleDeleteClick" class="btn btn-primary">Remove</button>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <button type="button" @click="handleAddClick" class="btn btn-primary">Add Number</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["phones"],

  mounted() {
    if (this.phones) {
      this.counter = this.phones.length;
      this.fields = this.phones;
    }
  },
  data: function() {
    return {
      counter: 1
    };
  },
  computed: {
    countFields: {
      get() {
        return this.phones.length;
      },
      set(newValue) {
        newValue;
      }
    },

    fields: {
      get() {
        return this.phones;
      },
      set(newValue) {
        newValue;
      }
    }
  },
  methods: {
    handleAddClick() {
      this.fields.push({
        id: ++this.counter,
        label: "",
        name: ""
      });
    },

    handleDeleteClick(e) {
      let el = e.target.parentNode.parentNode.parentNode.dataset.counter;

      this.fields.map((field, index) => {
        if (field.id == el) {
          this.fields.splice(index, 1);
        }
      });
    }
  }
};
</script>

<style>
</style>
