// ページ読み込み時、チャットエリアのスクロールを一番下にしておく
let chatScrollInner = $('#chatScrollInner').get(0);
if (chatScrollInner) chatScrollInner.scrollIntoView(false);