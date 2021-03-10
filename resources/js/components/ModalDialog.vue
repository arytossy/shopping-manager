<template>
    <div class="modal fade" :id="dialogId">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ dialogTitle }}</h5>
                    <button class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">
                        キャンセル
                    </button>
                    <slot name="button"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'dialogId',
        'dialogTitle',
    ]
}
</script>