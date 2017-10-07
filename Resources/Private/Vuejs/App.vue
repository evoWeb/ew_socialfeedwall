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
                parameter: 't3crr',

                allTweets: [],
                lineOne: [],
                lineTwo: [],
                lineThree: [],
                lineFour: [],

                sinceId: false
            }
        },

        mounted: function () {
            this.loadTweets();
        },

        methods: {
            getTweets: function (paging) {
                let self = this,
                    parameter = {
                        type: 1507271557071,
                        tx_ewsocialfeedwall_display: {
                            search: encodeURIComponent(this.parameter)
                        }
                    };

                if (this.sinceId) {
                    parameter.tx_ewsocialfeedwall_display.since_id = this.sinceId;
                }

                // GET request using the resource
                this.$http.get('/', {params: parameter}).then((response) => {
                    let tweets = response.body;

                    if (paging === false) {
                        self.allTweets = [];
                    }

                    for (let index = tweets.length - 1; index > -1; index--) {
                        let tweet = tweets[index];
                        // if no tweet is stored or id is not the same as the first tweet in store
                        // this is to prevent storing last tweet in response equal to first tweet
                        if (self.allTweets.length === 0 || tweet.id !== self.allTweets[0].id) {
                            self.allTweets.unshift(tweet);
                        }
                    }

                    // prevent memory consumption getting higher than displayable
                    self.allTweets = self.allTweets.slice(0,15);

                    self.lineOne = self.allTweets.slice(0,4);
                    self.lineTwo = self.allTweets.slice(4,8);
                    self.lineThree = self.allTweets.slice(8,12);
                    self.lineFour = self.allTweets.slice(12,15);

                    // for paging - https://dev.twitter.com/docs/working-with-timelines
                    self.sinceId = tweets[0].id;

                    // retry after amount of milli seconds
                    setTimeout(self.getMoreTweets, 60 * 1000);
                });
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
