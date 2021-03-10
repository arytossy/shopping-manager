<template>
    <div class="modal fade" id="friendAddDialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">友だち追加</h5>
                    <button class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div :class="['form-group', {'invalid': validationErrors}]">
                        <label for="email">メールアドレス</label>
                        <div class="d-flex">
                            <input type="email" name="email" class="form-control" v-model="searchEmail">
                            <button class="btn btn-primary btn-sm" @click="search()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div v-if="validationErrors" class="error-messages">
                            <p v-for="error in validationErrors" :key="error.key">
                                {{ error }}
                            </p>
                        </div>
                    </div>
                    <div id="searchResult">
                        <template v-if="status == 'yet'">
                            <div class="alert alert-info">
                                メールアドレスで検索してください
                            </div>
                        </template>
                        <template v-else-if="status == 'searching'">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">検索中...</span>
                                </div>
                            </div>
                        </template>
                        <template v-else-if="status == 'failed'">
                            <div class="alert alert-danger">
                                ユーザーが見つかりませんでした
                            </div>
                        </template>
                        <template v-else-if="status == 'found'">
                            <div id="profile" class="d-flex">
                                <img class="d-block" width="60" height="60" :src="result.avatar">
                                <div class="pl-3">
                                    <h5>{{ result.name }}</h5>
                                    <p class="text-muted">{{ result.email }}</p>
                                </div>
                            </div>
                            <form v-if="result.existsFriendship" :action="deleteUrl" method="post">
                                <input type="hidden" name="_token" :value="csrfToken">
                                <input type="hidden" name="user_id" :value="result.id">
                                <button type="submit" class="btn btn-danger">友だち削除する</button>
                            </form>
                            <form v-else :action="addUrl" method="post">
                                <input type="hidden" name="_token" :value="$root.csrfToken">
                                <input type="hidden" name="user_id" :value="result.id">
                                <button type="submit" class="btn btn-success">リクエストを送る</button>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['searchUrl', 'addUrl', 'deleteUrl'],
    data: function () { return {
        searchEmail: '',
        status: 'yet', // yet searching failed found のいずれか
        validationErrors: null,
        result: {
            id: 0,
            name: '',
            email: '',
            avatar: '',
            existsFriendship: '',
        },
    }},
    methods: {
        search: function() {
            this.status = 'searching';
            this.validationErrors = null;

            axios.post(this.searchUrl, {
                email: this.searchEmail,
            })
            .then((res) => {
                if (res.data) {
                    this.result = res.data;
                    this.status = 'found';
                } else {
                    this.status = 'failed';
                }
            })
            .catch((e) => {
                console.error(`ajax faild. ${e.response.data.message}`);
                this.validationErrors = e.response.data.errors ?? null;
                this.status = 'failed';
            });
        },
    },
}
</script>

<style scoped>
.error-messages {
    color: red;
    font-size: 15px;
    margin: 0;
}

.invalid input {
    border-color: red;
}
</style>