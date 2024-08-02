import { defineStore } from 'pinia';
import axios from 'axios'; 

export const useUrlStore = defineStore('urlStore', {
  // data 
  state: () => ({
    shortUrls: [],
    latestFullShortenedUrl: '',
  }),

  // methods 
  actions: {
    async fetchShortUrls() {
      try {
        const response = await axios.get('/short-urls'); 
        this.setUrls(response.data);

      } catch (error) {
        console.error('Failed to fetch short URLs:', error);
      }
    },
    addShortUrl(newUrl) {
      this.shortUrls.push(newUrl);
    },
    setUrls(urls) {
      this.shortUrls = urls;
    },
    setLatestFullShortenedUrl(url) {
      this.latestFullShortenedUrl = url;
    },
    deleteShortUrl(id) {
        this.shortUrls = this.shortUrls.filter(url => url.id !== id);
    },
    deleteAllShortUrls() {
        this.shortUrls = [];
    },
  },
});
