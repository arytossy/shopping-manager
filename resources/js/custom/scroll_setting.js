// ページ読み込み時、チャットエリアのスクロールを一番下にしておく
let chatScrollInner = $('#chatScrollInner').get(0);
if (chatScrollInner) chatScrollInner.scrollIntoView(false);

// 上記の処理によって全体のスクロールがずれてしまうのを直す
$('body').get(0).scrollIntoView(true);