// トグラによってモーダルダイアログの内容を分岐させる
//　詳しくはBootstrapのドキュメントのComponents->Modal->Varying modal contentを参照
$('#itemUpdateDialog').on('show.bs.modal', function (event) {
    var toggler = $(event.relatedTarget);
    var url = toggler.data('url');
    var boughtNumber = parseInt(toggler.text());
    
    var modal = $(this);
    modal.find('form').attr('action', url);
    modal.find('input[name="bought_number"]').val(boughtNumber);
});

$('#orderAddDialog').on('show.bs.modal', function (event) {
    var toggler = $(event.relatedTarget);
    var itemId = toggler.data('item');
    
    var modal = $(this);
    modal.find('input[name="item_id"]').val(itemId);
});

$('#orderChangeDialog').on('show.bs.modal', function (event) {
    var toggler = $(event.relatedTarget);
    var itemId = toggler.data('item');
    var requiredNumber = parseInt(toggler.text());
    
    var modal = $(this);
    modal.find('input[name="item_id"]').val(itemId);
    modal.find('input[name="required_number"]').val(requiredNumber);
});