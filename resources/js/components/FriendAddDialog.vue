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
                    <div :class="['form-group', {'invalid': validation_errors}]">
                        <label for="email">メールアドレス</label>
                        <div class="d-flex">
                            <input type="email" name="email" class="form-control" v-model="search_email">
                            <button class="btn btn-primary btn-sm" @click="search()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div v-if="validation_errors" class="error-messages">
                            <p v-for="error in validation_errors" :key="error.key">
                                {{ error }}
                            </p>
                        </div>
                    </div>
                    <div id="searchResult">
                        <div v-if="status == 'yet'">
                            <div class="alert alert-info">
                                メールアドレスで検索してください
                            </div>
                        </div>
                        <div v-else-if="status == 'searching'">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">検索中...</span>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="status == 'failed'">
                            <div class="alert alert-danger">
                                ユーザーが見つかりませんでした
                            </div>
                        </div>
                        <div v-else-if="status == 'found'">
                            <div id="profile" class="d-flex">
                                <img class="d-block" width="60" height="60" :src="result.avatar">
                                <div class="pl-3">
                                    <h5>{{ result.name }}</h5>
                                    <p class="text-muted">{{ result.email }}</p>
                                </div>
                            </div>
                            <form v-if="result.exists_friendship" :action="delete_url" method="post">
                                <input type="hidden" name="_token" :value="csrf_token">
                                <input type="hidden" name="user_id" :value="result.id">
                                <button type="submit" class="btn btn-danger">友だち削除する</button>
                            </form>
                            <form v-else :action="add_url" method="post">
                                <input type="hidden" name="_token" :value="csrf_token">
                                <input type="hidden" name="user_id" :value="result.id">
                                <button type="submit" class="btn btn-success">リクエストを送る</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['search_url', 'add_url', 'delete_url'],
    data: function () { return {
        csrf_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        search_email: '',
        status: 'yet', // yet searching failed found のいずれか
        validation_errors: null,
        result: {
            id: 0,
            name: '',
            email: '',
            avatar: '',
            exists_friendship: '',
        },
    }},
    methods: {
        search: function() {
            let _this = this;
            _this.status = 'searching';
            _this.validation_errors = null;

            axios.post(_this.search_url, {
                email: _this.search_email,
            })
            .then(function (res) {
                if (res.data) {
                    if (res.data.errors) {
                        _this.validation_errors = res.data.errors;
                        _this.status = 'failed';
                    } else {
                        _this.result = res.data;
                        _this.status = 'found';
                    }
                } else {
                    _this.status = 'failed';
                }
            })
            .catch(function (e) {
                console.log(`ajax was faild!\n${e}`);
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