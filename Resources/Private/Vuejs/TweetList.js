import Vue from 'vue';
import App from './App.vue';
import Tweets from './Component/Tweets.vue';
import Tweet from './Component/Tweet.vue';

Vue.component('tweets', Tweets);
Vue.component('tweet', Tweet);

window.app = new Vue({
	el: '#app',
	render: h => h(App)
});
