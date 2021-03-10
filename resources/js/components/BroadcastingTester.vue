<template>
    <div id="broadcastingTest">
        <h5>Broadcasting Test</h5>
        <div>{{ eventData }}</div>
    </div>
</template>

<script>
export default {
    props: ['threadId'],
    data: function () {
        return {
            eventData: "まだだよ",
        }
    },
    mounted() {
        Echo.private('thread.' + this.threadId)
            .listen('MessageModified', (event) => {
                console.log('message was modified!');
                this.eventData = event;
            });
    },
}
</script>

<style scoped>
#broadcastingTest {
    outline: 3px solid red;
}
</style>