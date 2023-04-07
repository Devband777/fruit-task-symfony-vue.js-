<template>
  <div id="app">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
      <a href="#" class="navbar-brand">Test</a>
      <div class="navbar-nav mr-auto">
        <li class="nav-item">
          <a href="/fruit" class="nav-link">Fruits</a>
        </li>
        <li class="nav-item">
          <a href="/favorite" class="nav-link">Favorite</a>
        </li>
      </div>
    </nav>

    <div class="container mt-3">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: "app",
};
</script>

<style>
.container {
  width: 100% !important;
  background-color: #f4f4f4;
  box-sizing: border-box;
  padding: 20px;
  min-height: 500px;
}
</style>
