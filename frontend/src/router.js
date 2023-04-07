import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      alias: "/fruit",
      name: "fruit",
      component: () => import("./components/FruitList")
    },
    {
      path: "/favorite",
      name: "add",
      component: () => import("./components/Favorite")
    }
  ]
});
