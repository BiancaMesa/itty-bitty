import { createStore } from 'vuex';

export default createStore({
    state() {
        return {
          fullShortenedUrl: '',
        };
    },
  mutations: {
    setFullShortenedUrl(state, url) {
      state.fullShortenedUrl = url;
    },
  },
  actions: {
    updateFullShortenedUrl({ commit }, url) {
      commit('setFullShortenedUrl', url);
    },
  },
  getters: {
    fullShortenedUrl: state => state.fullShortenedUrl,
  },
});
