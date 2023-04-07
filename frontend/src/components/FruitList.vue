<template>
  <div>
    <div class="row">
      <div class="filter">
        <form @submit.prevent="onFilterApply">
          <input placeholder="Filter by Name" class="form-control mr-2" type="text" id="name-filter" v-model="filterName">
          <input placeholder="Filter by Family" class="form-control mr-2" type="text" id="family-filter"
            v-model="filterFamily">
          <input type="submit" value="Apply" class="btn btn-primary">
        </form>
      </div>

    </div>
    <div class="row">
      <div class="list-control">
        <div style="display: flex; flex-direction: row; vertical-align: middle; align-items: center;">
          <span>Shows:</span>
          <select class="form-control" v-model="pageSize" @change="handlePageSizeChange($event)">
            <option v-for="size in pageSizes" :key="size" :value="size">
              {{ size }}
            </option>
          </select>
        </div>
        <b-pagination v-model="page" :total-rows="getTotalItems" :per-page="pageSize" prev-text="Prev" next-text="Next"
          @change="handlePageChange"></b-pagination>

      </div>

    </div>
    <div>
      <b-card-group columns>
          <b-card v-for="fruit in getFruit" :key="fruit.id" style="max-width: 350px" :title="fruit.name" class="mb-2">
            <b-card-text>
              <p>
                <span>
                  <b>Fmaily: </b>{{ fruit.family }}
                </span>
                <span>
                  <b>Genus: </b>{{ fruit.genus }}
                </span>
              </p>
              <p>
                <b>Nuturitious:</b>
              </p>
              <ul>
                <li>Protein: {{ fruit.protein }}</li>
                <li>Sugar: {{ fruit.sugar }}</li>
                <li>Carbohydrates: {{ fruit.carbohydrates }}</li>
                <li>Fat: {{ fruit.fat }}</li>
                <li>Calories: {{ fruit.calories }}</li>
              </ul>
            </b-card-text>

            <b-button @click="addToFavorites(fruit.id)" variant="primary">Add to favorites</b-button>
          </b-card>
      </b-card-group>
    </div>
    <div class="row">
      <div class="list-control">
        <div style="display: flex; flex-direction: row; vertical-align: middle; align-items: center;">
          <span>Shows:</span>
          <select class="form-control" v-model="pageSize" @change="handlePageSizeChange($event)">
            <option v-for="size in pageSizes" :key="size" :value="size">
              {{ size }}
            </option>
          </select>
        </div>
        <b-pagination v-model="page" :total-rows="getTotalItems" :per-page="pageSize" prev-text="Prev" next-text="Next"
          @change="handlePageChange"></b-pagination>

      </div>

    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions } from 'vuex';

export default {
  name: 'fruit-list',
  data() {
    return {
      filterName: '',
      filterFamily: '',
      pageSize: 5,
      pageSizes: [5, 10, 20],
      currentIndex: -1,
      page: 1,
    };
  },
  methods: {
    ...mapActions([
      'fetchFruit',
      'addToFavorites'
    ]),

    getRequestParams(page, pageSize, filterName, filterFamily) {
      let params = {};

      if (page) {
        params["page"] = page;
      }

      if (pageSize) {
        params["size"] = pageSize;
      }

      if(filterName) {
        params["name"] = filterName
      }

      if(filterFamily) {
        params["family"] = filterFamily
      }

      

      return params;
    },

    retrieveFruit() {
      const params = this.getRequestParams(
        this.page,
        this.pageSize,
        this.filterName,
        this.filterFamily,
      );
      this.fetchFruit(params);
    },

    handlePageChange(value) {
      this.page = value;
      this.retrieveFruit();
    },

    handlePageSizeChange(event) {
      this.pageSize = event.target.value;
      this.page = 1;
      this.retrieveFruit();
    },

    addToFavorites(id) {
      this.$store.dispatch("addToFavorites", id);
      alert("Added successfully")
    },

    onFilterApply() {
      this.retrieveFruit();
    }
  },
  
  computed: {
    ...mapGetters ([
      "getFruit",
      "getTotalItems",
      "getFavorites"
    ])
  },
  created() {
    this.retrieveFruit();
  },
};
</script>
<style>
.filter form {
  display: flex;
  flex-direction: row;
  box-sizing: border-box;
  padding: 20px;
  width: 100%;
}

.list-control {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  box-sizing: border-box;
  padding: 20px;
  width: 100%;
}

.fruit-list {
  width: 100%;
  max-width: 1000px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  padding: 0;
}

.fruit-item {
  width: 30%;
  list-style: none;
  margin: 5px;
  align-items: center;
  justify-content: center !important;
}
</style>