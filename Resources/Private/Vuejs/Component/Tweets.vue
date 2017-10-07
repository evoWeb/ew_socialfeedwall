<template>
    <div class="row clearfix">
        <div
            is="tweet"
            v-for="tweet in tweets"
            :tweet="tweet"
            class="three columns tweet">
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'tweets'
        ]
    };
</script>
