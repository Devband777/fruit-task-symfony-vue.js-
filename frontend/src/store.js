import Vue from "vue";
import Vuex from "vuex";

import FruitDataService from "./services/FruitDataService";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    fruit: [],
    favorites: [],
    totalItems: 0,
    countFavorites: 0,
    sumOfNutrition: 0,
  },

  getters: {
    getFruit: (state) => state.fruit,
    getTotalItems: (state) => state.totalItems,
    getFavorites: (state) => state.favorites,
    getCountFavorites: (state) => state.countFavorites,
    getSumOfNutrition: (state) => state.sumOfNutrition
  },

  mutations: {
    ADD_FRUIT: (state, fruit) => {
      state.fruit.push(fruit);
    },
    ADD_FAVORITE: (state, favorite) => {
      state.favorites.push(favorite);
    },
    SET_TOTALITEMS: (state, totalItems) => {
      state.totalItems = totalItems;
    },
    SET_COUNTFAVORITES: (state, countFavorites) => {
      state.countFavorites = countFavorites;
    },
    SET_SUMOFNUTURITION: (state, sumOfNutrition) => {
      state.sumOfNutrition = sumOfNutrition;
    },
    SET_FRUIT: (state, fruit) => {
      state.fruit = fruit;
    },
    SET_FAVORITES: (state, favorites) => {
      state.favorites = favorites;
    },
    REMOVE_FAVORITE: (state, index) => {
      state.favorites.splice(index, 1);
    },
  },

  actions: {
    async fetchFruit({ commit }, params) {
      await FruitDataService.getAll(params)
        .then((response) => {
          const { fruit, totalItems } = response.data;
          commit("SET_FRUIT", fruit);
          commit("SET_TOTALITEMS", totalItems);
          console.log(this.state);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    async fetchFavorites({ commit }) {
      await FruitDataService.getFavorites()
        .then((response) => {
          const { favorites, sumOfNutrition} = response.data;
          commit("SET_FAVORITES", favorites);
          commit("SET_COUNTFAVORITES", favorites.length);
          commit("SET_SUMOFNUTURITION", sumOfNutrition);
          console.log(response.data);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    async addToFavorites({ commit }, id) {
      console.log(id);
      await FruitDataService.addToFavorites(id)
        .then((response) => {
          console.log(response.data);
          const { favorite, success } = response.data;
          if (success) commit("ADD_FAVORITE", favorite);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    async removeFromFavorite({ commit }, fruitId, idx) {
      await FruitDataService.removeFromFavorites(fruitId)
        .then((response) => {
          console.log(response.data);
          if (response.data.success) commit("REMOVE_FAVORITE", idx);
          console.log(response.data);
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
});
