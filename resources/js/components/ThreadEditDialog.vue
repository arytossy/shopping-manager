<template>
    <ModalDialog dialog-id="threadEditDialog" dialog-title="スレッド情報編集">
        <div class="form-group">
            <label>タイトル</label>
            <input type="text" class="form-control" v-model="newTitle" :class="{invalid: errors ? errors.title : false}">
            <div class="error-messages" v-if="errors ? errors.title : false">
                <div v-for="message in errors.title" :key="message.key">{{ message }}</div>
            </div>
        </div>
        <div class="form-group">
            <label>場所</label>
            <input type="text" class="form-control" v-model="newWhereGo" :class="{invalid: errors ? errors.where_go : false}">
            <div class="error-messages" v-if="errors ? errors.where_go : false">
                <div v-for="message in errors.where_go" :key="message.key">{{ message }}</div>
            </div>
        </div>
        <div class="form-group">
            <label>日にち</label>
            <input type="date" class="form-control" v-model="newWhenGo" :class="{invalid: errors ? errors.when_go : false}">
            <div class="error-messages" v-if="errors ? errors.when_go : false">
                <div v-for="message in errors.when_go" :key="message.key">{{ message }}</div>
            </div>
        </div>
        
        <template slot="button">
            <button class="btn btn-success" @click="updateThread()">
                更新
            </button>
        </template>
    </ModalDialog>
</template>

<script>
import ModalDialog from "./ModalDialog"

export default {
    props: [
        'threadId',
        'title',
        'whereGo',
        'whenGo',
        'updateThreadUrl',
    ],
    data: function() {
        return {
            newTitle: this.title,
            newWhereGo: this.whereGo,
            newWhenGo: this.whenGo,
            errors: null,
        };
    },
    methods: {
        updateThread() {
            this.errors = null;
            axios.put(this.updateThreadUrl, {
                title: this.newTitle,
                where_go: this.newWhereGo,
                when_go: this.newWhenGo
            })
            .then((res) => {
                console.log('thread updated successful.');
            })
            .catch((e) => {
                console.error(`ajax failed: ${e.response.data.message}`);
                if (e.response.data.errors) {
                    this.errors = e.response.data.errors;
                }
            });
        },
    },
    mounted () {
        
    },
}
</script>

<style scoped>
.error-messages {
    font-size: 15px;
    color: red;
}
input.invalid {
    border-color: red;
}
</style>