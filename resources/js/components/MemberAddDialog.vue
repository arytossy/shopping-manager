<template>
    <ModalDialog dialog-id="memberAddDialog" dialog-title="メンバー追加">
        <template v-if="notMemberFriends.length > 0">
            <div class="form-group">
                <div v-for="friend in notMemberFriends" :key="friend.key">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" :value="friend.id" v-model="newMembers">
                            <div class="d-flex">
                                <img width="30" height="30" :src="friend.avatar" >
                                <span class="pl-2">{{ friend.name }}</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="alert alert-warning" role="alert">
                追加できる友だちがもういません！<br>
                <a :href="friendIndexUrl">友だちを追加する？</a>
            </div>
        </template>

        <template slot="button">
            <button class="btn btn-success" @click="addMembers()">
                追加
            </button>
        </template>
    </ModalDialog>
</template>

<script>
import ModalDialog from "./ModalDialog"

export default {
    props: [
        'threadId',
        'getFriendsUrl',
        'friendIndexUrl',
        'addMembersUrl',
    ],
    data: function() {
        return {
            notMemberFriends: [],
            newMembers: [],
        };
    },
    methods: {
        getFriends() {
            axios.get(this.getFriendsUrl, {
                params: {
                    thread_id: this.threadId,
                }
            })
            .then((res) => {
                this.notMemberFriends = res.data;
            })
            .catch((e) => {
                console.error(`ajax failed. ${e.response.data.message}`);
            });
        },
        addMembers() {
            axios.post(this.addMembersUrl, {
                members: this.newMembers,
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
    mounted () {
        this.getFriends();

        Echo.private('thread.' + this.threadId)
            .listen('MemberAdded', (event) => {
                let notMemberFriends = this.notMemberFriends.slice();
                const newMemberIds = event.members.map(m => m.id);
                notMemberFriends = notMemberFriends.filter((f) => {
                    return ! newMemberIds.includes(f.id)
                });
                this.notMemberFriends = notMemberFriends;
            })
            .listen('MemberDeleted', (event) => {
                this.getFriends();
            });
    },
}
</script>