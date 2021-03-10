<template>
    <div id="itemList">
        <div id="itemListHeader" class="row">
            <div class="col-1">
                <a data-toggle="modal" href="#itemCreateDialog">
                    <i class="fas fa-plus-circle text-success"></i>
                </a>
            </div>
            <div class="col-7">買うもの</div>
            <div class="col-2 pl-0">必要</div>
            <div class="col-2 pl-0">購入</div>
        </div>

        <!-- 買うものリスト -->
        <template v-if="status === 'getting'">
             <div class="text-center my-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">取得中...</span>
                </div>
            </div>
        </template>
        <template v-if="status === 'failed'">
            <div class="alert alert-danger mt-3">
                リストの取得に失敗しました。<br>
                ページを再読み込みしてください。
            </div>
        </template>
        <template v-if="status === 'done'">
            <template v-if="items.length === 0">
                <div class="row">
                    <div class="col py-3">
                        <div class="alert alert-warning">
                            <i class="far fa-hand-point-up"></i>
                            ＋ボタンを押して買うものを追加しよう！
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div v-for="item in items" :key="item.key">
                    <div class="row border-bottom py-2">
                        <div class="col-1">
                            <item-list-checkbox
                                :item="item"
                                :update-item-url="updateItemUrl"
                            ></item-list-checkbox>
                        </div>
                        <div class="col-7">
                            <a data-toggle="collapse" :href="`#orders${item.id}`">
                                {{ item.name }}
                            </a>
                        </div>
                        <div class="col-2 pl-0">{{ item.required_total }}</div>
                        <div class="col-2 pl-0">
                            <a data-toggle="modal" :data-item-id="item.id" href="#itemUpdateDialog">
                                {{ item.bought_number }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- オーダー詳細 -->
                    <div class="collapse" :id="`orders${item.id}`">
                        <!-- 「みんなでシェア」の場合は誰でも削除、必要数変更できる -->
                        <template v-if="item.is_shared">
                            <div class="row py-1">
                                <div class="col-1">
                                    <!-- <form method="post" action="{{ route('items.destroy', $item->id) }}" onSubmit="return delete_check('item', '{{ $item->name }}')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                    </form> -->
                                </div>
                                <div class="col-7">みんなでシェア</div>
                                <div class="col-2 pl-0">
                                    <a data-toggle="modal" :data-item-id="item.id" href="#orderChangeDialog">
                                        {{ item.required_total }}
                                    </a>
                                </div>
                                <div class="col-2 pl-0"></div>
                            </div>
                        </template>
                        <!-- 個人的なオーダー -->
                        <template v-else>
                            <template v-for="orderer in item.users">
                                <div class="row mt-1" :key="orderer.key">
                                    <div class="col-1">
                                        <template v-if="orderer.is_myself">
                                            <!-- <form method="post" action="{{ route('orders.destroy') }}" onSubmit="return delete_check('order', '{{ $item->name }}')">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                            </form> -->
                                        </template>
                                    </div>
                                    <div class="col-7 d-flex">
                                        <img width="30" height="30" :src="orderer.avatar">
                                        <span class="pl-2">{{ orderer.name }}</span>
                                    </div>
                                    <div class="col-2 pl-0">
                                        <template v-if="orderer.is_myself">
                                            <a data-toggle="modal" :data-item-id="item.id" href="#orderChangeDialog">
                                                {{ orderer.required_number }}
                                            </a>
                                        </template>
                                        <template v-else>
                                            {{ orderer.required_number }}
                                        </template>
                                    </div>
                                    <div class="col-2 pl-0"></div>
                                </div>
                            </template>
                            <template v-if="item.me_too">
                                <div class="row py-1">
                                    <div class="offset-1 col-7">
                                        <a data-toggle="modal" :data-item-id="item.id" href="#orderAddDialog">
                                            <i class="fas fa-plus-circle text-success"></i> 自分も欲しい！
                                        </a>
                                    </div>
                                </div>
                            </template>
                            
                        </template>
                        
                        <div class="row border-bottom"></div>
                        
                    </div>
                </div>
            </template>
        </template>
        
    </div>
    
</template>

<script>
export default {
    props: ['threadId', 'getItemsUrl', 'updateItemUrl'],
    data() {
        return {
            items: [],
            status: 'getting' // getting done failed のいずれか
        }
    },
    mounted() {
        axios.get(this.getItemsUrl, {
            params: {
                thread_id: this.threadId,
            }
        })
        .then((res) => {
            this.status = 'done';
            this.items = res.data.map((i) => {
                if (i.users.some((u) => u.is_myself)) {
                    i.me_too = false;
                }
                return i;
            });
        })
        .catch((e) => {
            this.status = 'failed';
            console.error(`ajax failed: ${e.response.data.message}`);
        });

        Echo.private('thread.' + this.threadId)
            .listen('ItemUpdated', (event) => {
                const items = this.items.map((i) => {
                    if (i.id === event.item.id) {
                        i.bought_number = event.item.bought_number;
                    }
                    return i;
                });
                this.items = items;
            });
    }
}
</script>