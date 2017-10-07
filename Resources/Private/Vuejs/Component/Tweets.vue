<template>
    <div
        is="tweet"
        v-for="tweet in tweets"
        :tweet="tweet"
        class="three columns tweet">
    </div>
</template>

<script>
    export default {
        props: [
            'tweets'
        ]
    };
</script>
