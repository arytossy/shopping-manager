<template>
    <div class="item-list-checkbox">
        <template v-if="isProcessing">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">...</span>
            </div>
        </template>
        <template v-else>
            <template v-if="item.bought_number >= item.required_total">
                <a href="#" @click="updateBoughtNumber(item.id, 0)">
                    <i class="fas fa-check-square text-primary"></i>
                </a>
            </template>
            <template v-else-if="item.bought_number > 0">
                <a href="#" @click="updateBoughtNumber(item.id, item.required_total)">
                    <i class="fas fa-check-square text-warning"></i>
                </a>
            </template>
            <template v-else-if="item.bought_number == 0">
                <a href="#" @click="updateBoughtNumber(item.id, item.required_total)">
                    <i class="far fa-square text-secondary"></i>
                </a>
            </template>
        </template>
    </div>
</template>

<script>
export default {
    props: ['item', 'updateItemUrl'],
    data() {
        return {
            isProcessing: false,
        }
    },
    computed: {
        purchaseStatus() {
            if (this.item.bought_number >= this.item.required_total) {
                return "done"
            } else if (this.item.bought_number > 0) {
                return "halfway"
            } else {
                return "none"
            }
        },
        iconClass() {
            if (this.purchaseStatus === "done") {
                return "fas fa-check-square text-primary"
            } else if (this.purchaseStatus === "") {
                return "fas fa-check-square text-warning"
            } else {
                return "far fa-square text-secondary"
            }
        },

    },
    methods: {
        updateBoughtNumber(itemId, newNumber) {
            this.isProcessing = true;
            axios.put(`${this.updateItemUrl}/${itemId}`, {
                bought_number: newNumber,
            })
            .then((res) => {
                this.isProcessing = false;
                console.log('bought number updated successful.');
            })
            .catch((e) => {
                console.error(`ajax failed: ${e.response.data.message}`)
            })
        }
    }
}
</script>