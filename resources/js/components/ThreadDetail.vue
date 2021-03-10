<template>
    <div id="threadDetail">
        <div id="threadDetailHeader" class="row">
            <div class="col-10">
                <a data-toggle="collapse" href="#detailContent">
                    {{ currentTitle }}
                </a>
            </div>
            <div class="col-2">
                <a data-toggle="modal" href="#threadEditDialog">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        <div id="detailContent" class="collapse">
            <div class="row border-top py-1">
                <div class="col-3 pr-0"><strong>場所</strong></div>
                <div class="col-9">{{ currentWhereGo }}</div>
            </div>
            <div class="row border-top py-1">
                <div class="col-3 pr-0"><strong>日時</strong></div>
                <div class="col-9">{{ currentWhenGo }}</div>
            </div>
            <div class="row border-top py-1">
                <div class="col-3 pr-0"><strong>メンバー</strong></div>
                <div class="col-7">
                    <template v-if="status === 'getting'">
                        <div class="text-center my-5">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">取得中...</span>
                            </div>
                        </div>
                    </template>
                    <template v-if="status === 'failed'">
                        <div class="alert alert-danger mt-3">
                            メンバーの取得に失敗しました。<br>
                            ページを再読み込みしてください。
                        </div>
                    </template>
                    <template v-if="status === 'done'">
                        <div v-for="member in members" :key="member.key">
                            <div class="row mt-1">
                                <div class="col-1">
                                    <button class="btn-wrapper" @click="deleteMember(member)">
                                        <i class="fas fa-minus-circle text-danger"></i>
                                    </button>
                                </div>
                                <div class="col-10 d-flex">
                                    <img width="30" height="30" :src="member.avatar">
                                    <span class="pl-2">{{ member.name }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                </div>
                <div class="col-2">
                    <a data-toggle="modal" href="#memberAddDialog">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'id',
        'title',
        'whereGo',
        'whenGo',
        'getMembersUrl',
        'deleteMembersUrl'
    ],
    data: function () {
        return {
            currentTitle: this.title,
            currentWhereGo: this.whereGo,
            currentWhenGo: changeFormat(this.whenGo),
            members: null,
            status: 'getting' // getting done failed のいずれか
        }
    },
    methods: {
        deleteMember(member) {
            if (window.delete_check('member', member.name)) {
                axios.post(this.deleteMembersUrl, {
                    thread_id: this.id,
                    user_id: member.id,
                })
                .then((res) => {
                    console.log('member was deleted successful.');
                })
                .catch((e) => {
                    console.error(`ajax failed. ${e.response.data.message}`);
                });
            }
        },
    },
    mounted() {
        axios.get(this.getMembersUrl, {
            params: {
                thread_id: this.id,
            },
        })
        .then((res) => {
            this.status = 'done';
            this.members = res.data;
        })
        .catch((e) => {
            this.status = 'failed'
            console.error(`ajax failed. ${e.response.data.message}`)
        });

        Echo.private('thread.' + this.id)
            .listen('MemberDeleted', (event) => {
                let members = this.members.slice();
                members = members.filter((m) => {
                    return m.id !== event.member.id;
                });
                this.members = members;
            })
            .listen('MemberAdded', (event) => {
                let members = this.members.slice();
                members = members.concat(event.members);
                members.sort((a, b) => {
                    return a.id - b.id;
                });
                this.members = members;
            })
            .listen('ThreadDetailUpdated', (event) => {
                this.currentTitle = event.thread.title;
                this.currentWhereGo = event.thread.where_go;
                this.currentWhenGo = changeFormat(event.thread.when_go);
            });
    }
}

function changeFormat(input) {
    const dateElements = input.split(' ')[0].split('-');
    return `${dateElements[0]}/${parseInt(dateElements[1])}/${parseInt(dateElements[2])}`;
}
</script>

<style lang="scss" scoped>
#threadDetailHeader {
    padding: 10px 0;
    font-weight: bold;
    font-size: 18px;
}
</style>