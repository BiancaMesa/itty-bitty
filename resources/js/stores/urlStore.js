// Import defineStore to define a new pinia store
import { defineStore } from 'pinia';
// Import axios to make HTTP requests. 
import axios from 'axios'; 

// We call the dfineStore method. 
// The first argument is a name (which will show in devTools).
// The second argument is an object where we will declare the state and the actions we might have. 
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
        //console.log('response from urlStore fetch:', response);
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
