<template>
    <div class="tweet-content">
        <p>{{ tweet.text }}</p>
    </div>
    <div class="tweet-author">
        <img :src="{{ tweet.user.profile_image_url_https }}"/>
        <div class="name">{{ tweet.user.screen_name }}</div>
    </div>
</template>

<script>
    export default {
        props: [
            'tweet'
        ]
    };
</script>
