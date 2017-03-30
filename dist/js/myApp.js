function updateChat() {
  console.clear();
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: 'chatUpdate=chat',
        success: function(data) {
            $("#messages").html(data);
        }
    });
}
$(function() {
    $('.twemoji-picker').twemojiPicker({
      init: ':thumbsup: Hello :hatching-chick:',
      size: '25px',
      icon: 'grinning',
      iconSize: '25px',
      height: '80px',
      width: '100%',
      category: ['smile', 'cherry-blossom', 'video-game', 'oncoming-automobile', 'symbols'],
      categorySize: '20px',
      pickerPosition: 'bottom',
      pickerHeight: '150px',
      pickerWidth: '100%'
    });
})