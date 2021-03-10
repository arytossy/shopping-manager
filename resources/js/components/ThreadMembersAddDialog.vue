<template>
    <ModalDialog dialog-id="memberAddDialog" dialog-title="メンバー追加">
        <template v-if="notMemberFriends.length > 0">
            <div class="form-group">
                <div v-for="friend in notMemberFriends" :key="friend.key">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" :value="friend.id" v-model="newMemberIds">
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
        'friendIndexUrl',
        'notMemberFriends'
    ],
    data: function() {
        return {
            newMemberIds: [],
        };
    },
    methods: {
        addMembers() {
            this.$emit('addMembers', this.newMemberIds);
        }        
    },
    mounted () {

    },
}
</script>