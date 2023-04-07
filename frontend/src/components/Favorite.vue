<template>
  <div>
    <div class="row" v-if="getCountFavorites">
      <div class="col-md-6">
        <h1>Favorite List</h1>
        <b-list-group>
          <b-list-group-item v-for="(fruit, idx) in getFavorites" :key="fruit.id"
            class="d-flex justify-content-between align-items-center">
            {{ fruit.name }} ({{ fruit.family }})
            <span><b-button size="sm" @click="removeFromFavorites(fruit, idx)" variant="danger">Remove</b-button></span>
          </b-list-group-item>
        </b-list-group>
      </div>
      <div class="col-md-6">
        <h1>Sum of nutritions facts of all favorite fruit: <span>{{ getSumOfNutrition }}</span> </h1>
          <a class="btn btn-primary" href="/fruits">Go to List</a>
      </div>
    </div>
    <div v-else>
      <h1 class="text-muted">Nothing favorites</h1>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
export default {
  name:"favorite",
  computed: {
    ...mapGetters([
      "getFavorites",
      "getCountFavorites",
      "getSumOfNutrition"
    ])
  },
  methods: {
    ...mapActions([
      'fetchFavorites',
      'removeFromFavorite'
    ]),
    removeFromFavorites(fruit, idx) {
      this.$store.dispatch("removeFromFavorite", fruit.id, idx);
    },
  },

  created() {
    this.fetchFavorites();
    
  },
};
</script>