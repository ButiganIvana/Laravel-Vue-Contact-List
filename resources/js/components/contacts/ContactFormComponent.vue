<template>
  <div class="card-body">
    <div class="form-group" style="text-align:center;">

      <div v-if="Array.isArray(data.profile_photo)">
        <div class="upload-btn-wrapper">
          <button class="btn2">
            <div>+</div>
            <div>Upload an image</div>
          </button>
          <input type="file" @change="onFileChange">
        </div>
      </div>

      <div v-else>
        <img class="upload-btn-wrapper" :src="data.profile_photo">
        <div>
          <button class="btn btn-danger btn-custom" @click="removeImage">Remove image</button>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="firstName">First Name</label>
      <input
        type="text"
        v-model="data.first_name"
        class="form-control"
        id="firstName"
        placeholder="Enter first name"
      >
    </div>

    <div class="form-group">
      <label for="lastName">Last Name</label>
      <input
        type="text"
        v-model="data.last_name"
        class="form-control"
        id="lastName"
        placeholder="Enter last name"
      >
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input
        type="email"
        v-model="data.email"
        class="form-control"
        id="email"
        placeholder="Enter email"
      >
    </div>

    <div class="form-group">
      <label for="numbers">Numbers</label>
      <add-numbers-component :phones="data.phones"/>
    </div>
  </div>
</template>

<script>
import AddNumbersComponent from "./AddNumbersComponent";
export default {
  props: ["data"],
  components: {
    AddNumbersComponent
  },

    methods: {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);

    },

    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = e => {
        vm.data.profile_photo = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage: function(e) {
      this.data.profile_photo = [];
    },
  }
};
</script>

<style>
input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
}

input[type=file], /* FF, IE7+, chrome (except button) */
input[type=file]::-webkit-file-upload-button { /* chromes and blink button */
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
  font-size: 20px;
  font-weight: bold;
  width: 200px;
  height: 200px;
}

.btn-custom {
  width: 200px;
  border-radius: 0px;
}

</style>
