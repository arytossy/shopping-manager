<template>
    <div id="messageSender">
        <div class="d-flex">
            <textarea name="content" rows="1" class="form-control"
                v-model="content"
                :class="{invalid: validationErrors}"
            ></textarea>
            <div id="sendBtn">
                <div v-if="isSending">
                    <div class="waiting">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">送信中...</span>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <button class="btn btn-primary btn-sm"
                        @click="send()"
                        :disabled="!content">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="error-message" v-if="validationErrors">
            <div v-for="error in validationErrors.content" :key="error.key">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['sendUrl', 'threadId'],
    data: function() {
        return {
            content: '',
            validationErrors: null,
            isSending: false,
        }
    },
    methods: {
        send: function() {
            this.validationErrors = null;
            this.isSending = true;
            axios.post(this.sendUrl, {
                content: this.content,
                thread_id: this.threadId,
            })
            .then((res) => {
                this.content = '';
                console.log('message sent successful.');
                this.isSending = false;
            })
            .catch((e) => {
                console.error(`ajax faild: ${e.response.data.message}`);
                this.validationErrors = e.response.data.errors ?? null;
                this.isSending = false;
            });
        }
    }
}
</script>

<style lang="scss" scoped>
#messageSender {
    width: 100%;
    position: sticky;
    bottom: 0;

    textarea.invalid {
        border-color: red;
    }

    #sendBtn > div {
        width: 40px;
        height: 40px;

        .waiting {
            width: 100%;
            height: 100%;
            text-align: center;
            background-color: #aaa;
            color: #fff;
            border-radius: 3px;
            padding: 7px;

            .spinner-border {
                display: block;
                width: 26px;
                height: 26px;
                border-width: 4px;
            }
        }

        button {
            display: block;
            width: 100%;
            height: 100%;

            &:disabled {
                background-color: #aaa;
                opacity: 1;
                border-color: #aaa;
            }
        }
    }
}

.error-message {
    font-size: 15px;
    color: red;
}
</style>