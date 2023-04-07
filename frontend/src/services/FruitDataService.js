import http from "../http-common";

class FruitDataService {
  getAll(params) {
    return http.get("/fruit/", { params });
  }

  get(id) {
    return http.get(`/fruit/${id}`);
  }

  getFavorites() {
    return http.get('/fruit/favorites');
  }

  addToFavorites(id) {
    return http.post(`/fruit/${id}/add-to-favorites`);
  }

  removeFromFavorites(id) {
    return http.post(`/fruit/${id}/remove-from-favorites`);
  }
}

export default new FruitDataService();
