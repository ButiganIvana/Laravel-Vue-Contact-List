<template>
  <div>
    <div v-show="phones == null || phones.length == 0">
      <h5>No numbers.</h5>
    </div>

    <div v-for="phone in phones" :key="phone.id">
      <label for="email">{{phone.label}}</label>
      <label for="phone">{{phone.name}}</label>
    </div>

  </div>
</template>

<script>
export default {
  props: ["phones"]
};
</script>

<style>
</style>
