<template>
    <div class="tweet-list">

        <div is="tweets" :tweets="lineOne"></div>
        <div is="tweets" :tweets="lineTwo"></div>
        <div is="tweets" :tweets="lineThree"></div>
        <div is="tweets" :tweets="lineFour"></div>

    </div>
</template>

<script>
    import Vue from 'vue';
    import VueResource from 'vue-resource';
    Vue.use(VueResource);

    export default {
        data () {
            return {
                parameter: '',

                allTweets: [],
                lineOne: [],
                lineTwo: [],
                lineThree: [],
                lineFour: [],

                paging: true,
                sinceId: false
            }
        },

        created: function () {
            this.parameter = document.querySelector(this.$root.$options.el).getAttribute('data-search');
        },

        mounted: function () {
            this.loadTweets();
        },

        methods: {
            /**
             * @param {boolean} paging
             */
            getTweets: function (paging) {
                let parameter = {
                        type: 15072715,
                        tx_ewsocialfeedwall_display: {
                            search: encodeURIComponent(this.parameter)
                        }
                    };

                this.paging = paging;

                if (this.sinceId) {
                    parameter.tx_ewsocialfeedwall_display.since_id = this.sinceId;
                }

                // GET request using the resource
                this.$http.get('/', {params: parameter}).then(this.processAjaxResponse);
            },

            /**
             * Takes tweets from ajax request and split them into rows
             *
             * @param {object} response
             */
            processAjaxResponse: function (response) {
                let tweets = response.body;

                if (this.paging === false) {
                    this.allTweets = [];
                }

                if (tweets.length > 0) {
                    for (let index = tweets.length - 1; index > -1; index--) {
                        let tweet = tweets[index];
                        // if no tweet is stored or id is not the same as the first tweet in store
                        // this is to prevent storing last tweet in response equal to first tweet
                        if (this.allTweets.length === 0 || tweet.id !== this.allTweets[0].id) {
                            this.allTweets.unshift(tweet);
                        }
                    }

                    // prevent memory consumption getting higher than displayable
                    this.allTweets = this.allTweets.slice(0,15);

                    this.lineOne = this.allTweets.slice(0,4);
                    this.lineTwo = this.allTweets.slice(4,8);
                    this.lineThree = this.allTweets.slice(8,12);
                    this.lineFour = this.allTweets.slice(12,15);

                    // for paging - https://dev.twitter.com/docs/working-with-timelines
                    this.sinceId = tweets[0].id;
                }

                // retry after amount of milli seconds
                setTimeout(this.getMoreTweets, 60 * 1000);
            },

            getMoreTweets: function () {
                this.getTweets(true);
            },

            loadTweets: function () {
                this.sinceId = false;
                this.getTweets(false);
            }
        }
    }
</script>
