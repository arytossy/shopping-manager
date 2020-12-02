// 削除リクエストを送る前に確認するメソッド
window.delete_check = function (category, target, isMyself = false) {
    let content = '';

    switch (category) {
        case 'friend':
            content = `以下の友だちを削除します！\n${target}\nよろしいですか？`;
            break;
        case 'member':
            if (isMyself) {
                content = 'このスレッドから退出します！\n※最後の一人の場合はスレッドごと削除します！\nよろしいですか？';
            } else {
                content = `以下のユーザーをこのスレッドから外します！\n${target}\nよろしいですか？`;
            }
            break;
        case 'item':
            content = `以下の買うものを削除します！\n${target}\nよろしいですか？`;
            break;
        case 'order':
            content = `以下の品目の自分のオーダーを取り消します。\n${target}\n※最後の一人の場合は品目ごと削除します！\nよろしいですか？`;
            break;
        case 'message':
            content = `以下のコメントを削除します！\n${target}\nよろしいですか？`;
            break;
    }
    
    return window.confirm(content);
}