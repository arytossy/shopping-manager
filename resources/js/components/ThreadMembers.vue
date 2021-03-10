<template>
    <div id="threadMembers">
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
        <ThreadMembersAddDialog
            :friend-index-url="friendIndexUrl"
            :not-member-friends="notMemberFriends"
            @addMembers="addMembers"
        />
    </div>
</template>

<script>
import ThreadMembersAddDialog from "./ThreadMembersAddDialog";

export default {
    props: [
        'threadId',
        'getMembersUrl',
        'getFriendsUrl',
        'addMembersUrl',
        'deleteMembersUrl',
        'friendIndexUrl'
    ],
    data: function () {
        return {
            status: 'getting', // getting done failed のいずれか
            members: [],
            friends: [],
        }
    },
    methods: {
        deleteMember(member) {
            if (window.delete_check('member', member.name)) {
                axios.post(this.deleteMembersUrl, {
                    thread_id: this.threadId,
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
        addMembers(newMemberIds) {
            axios.post(this.addMembersUrl, {
                members: newMemberIds,
                thread_id: this.threadId,
            })
            .then((res) => {
                console.log('member added successful.');
            })
            .catch((e) => {
                console.error(`ajax failed. ${e.response.data.message}`);
            })
        },
    },
    computed: {
        notMemberFriends() {
            const friends = this.friends.slice();
            const memberIds = this.members.map((m) => m.id);
            const notMemberFriends = friends.filter((f) => {
                return !memberIds.includes(f.id);
            });
            return notMemberFriends;
        }
    },
    mounted() {
        axios.get(this.getMembersUrl, {
            params: {
                thread_id: this.threadId,
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

        axios.get(this.getFriendsUrl, {
            // params: {
            //     thread_id: this.threadId,
            // },
        })
        .then((res) => {
            this.friends = res.data;
        })
        .catch((e) => {
            console.error(`ajax failed. ${e.response.data.message}`)
        });

        Echo.private('thread.' + this.threadId)
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
            });
    }
}
</script>

<style scoped>

</style>