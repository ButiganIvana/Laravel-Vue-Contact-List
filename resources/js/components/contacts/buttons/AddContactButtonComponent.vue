<template>
  <div style class="card">
    <div class="card-body">
      <router-link to="/contact/create">
        +
      </router-link>
    </div>
  </div>
</template>

<script>
</script>

<style scoped>
a:hover {
  text-decoration: none;
}

.card {
  width: 288px;
  margin-bottom: 20px;
}

.card-body {
  font-size: 100px;
}
.card-body a {
        height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
