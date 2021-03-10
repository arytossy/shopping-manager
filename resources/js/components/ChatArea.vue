<template>
    <div id="chatArea" class="row">
        <div class="col">
            <template v-if="status === 'getting'">
                <div class="text-center my-5">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">取得中...</span>
                    </div>
                </div>
            </template>
            <template v-else-if="status === 'failed'">
                <div class="alert alert-danger mt-3">
                    メッセージの取得に失敗しました。<br>
                    ページを再読み込みしてください。
                </div>
            </template>
            <template v-if="status === 'done'">
                <div v-for="message in messages" :key="message.key" class="my-2">
                    <template v-if="message.user.id == myId">
                        <div class="my-message pr-3">
                            <button class="btn-wrapper" @click="destroy(message)"><i class="fas fa-minus-circle text-danger"></i></button>
                            <p class="bubble ml-2">{{ message.content }}</p>
                        </div>
                    </template>
                    <template v-else>
                        <div class="message">
                            <img width="30" height="30" :src="message.user.avatar">
                            <div class="ml-3">
                                <p class="said_by">{{ message.user.name }}</p>
                                <p class="bubble">{{ message.content }}</p>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    props: ['myId', 'threadId', 'getUrl', 'deleteUrl'],
    data: function () {
        return {
            messages: null,
            status: 'getting' // getting done failed のいずれか
        };
    },
    methods: {
        destroy: function (message) {
            if (window.delete_check('message', message.content)) {
                axios.delete(`${this.deleteUrl}/${message.id}`)
                .then(()=>{
                    console.log('message was deleted successful.')
                })
                .catch((e)=>{
                    console.error(`ajax failed. ${e}`);
                });
            }
        },
    },
    mounted() {
        axios.get(this.getUrl, {
            params: {
                thread_id: this.threadId,
            },
        })
        .then((res) => {
            this.status = 'done'
            this.messages = res.data ?? null;
        })
        .catch((e) => {
            this.status = 'failed';
            console.error(`ajax failed. ${e.response.data.message}`);
        });

        Echo.private('thread.' + this.threadId)
            .listen('MessageAdded', (event) => {
                let messages = this.messages.slice();
                messages.push(event.message);
                messages.sort((a, b) => {
                    return a.id - b.id;
                });
                this.messages = messages;
            })
            .listen('MessageDeleted', (event) => {
                let messages = this.messages.slice();
                messages = messages.filter((m) => {
                    return m.id !== event.message.id;
                });
                this.messages = messages;
            })
    },
    updated() {
        const chatArea = document.getElementById('chatArea');
        chatArea.scrollTop = chatArea.scrollHeight;
    }
}
</script>

<style lang="scss" scoped>
#chatArea {
    height: 60vh;
    overflow-y: scroll;
    background-color: #def;
}

$bubble_radius: 5px;
$jag_length: 10px;
$jag_upper_skew: 3px;
$jag_lower_skew: 5px;
$bubble_color: #fff;
$my_color: #bcf;

.message {
    display: flex;
    max-width: 80%;

    .said_by {
        font-size: 10px;
        color: #888;
        margin: 0;
    }
    
    .bubble {
        position: relative;
        background-color: $bubble_color;
        border-radius: $bubble_radius;
        padding: 3px 10px;
        white-space: pre-wrap;
        margin: 0;
    
        &::before {
            content: '';
            position: absolute;
            left: -$jag_length;
            top: $bubble_radius;
            width: 0;
            height: 0;
            border-right: $jag_length solid $bubble_color;
            border-top: $jag_upper_skew solid transparent;
            border-bottom: $jag_lower_skew solid transparent;
        }
    }
}

.my-message {
    @extend .message;
    justify-content: flex-end;
    margin-left: auto;

    .bubble {
        background-color: $my_color;

        &::before {
            left: auto;
            right: -$jag_length;
            transform: rotateY(180deg);
            border-right-color: $my_color;
        }
    }
}
</style>