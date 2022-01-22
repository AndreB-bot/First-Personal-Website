

$(function() {
  $('#commentform').submit(handleSubmit);
});


function handleSubmit() {
  let form = $(this);
  
  postComment(form.serialize());

  return false;
}

function postComment(data) {
  $.ajax({
    type: 'POST',
    url: '../scripts/post_comment.php',
    data: data,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  }).then(res => {
      res = JSON.parse(res);
      console.log(res);
      if(res){
          postSuccess(res);
      }
  });
}

function postSuccess(data) {
  // Reset form values.
  $('#commentform').get(0).reset();
  // Create new li element.
  displayComment(data);
}

function displayComment(data) {
  let commentHtml = createComment(data);
  let commentEl = $(commentHtml);
  
  // Hide element before display.
  commentEl.hide();
  
  var postsList = $('#posts-list');
  postsList.addClass('has-comments');
  
  postsList.prepend(commentEl);
  commentEl.slideDown();
}

function createComment(data) {
  let html = '' +
  '<li><article id="' + data.id + '" class="hentry">' +
    '<footer class="post-info">' +
      '<abbr class="published" title="' + data.date + '">' +
        parseDisplayDate(data.date) +
      '</abbr>' +
      '<address class="vcard author">' +
        'By <a class="url fn" href="#">' + data.username + '</a>' +
      '</address>' +
    '</footer>' +
    '<div class="entry-content">' +
      '<p>' + data.comment + '</p>' +
    '</div>' +
  '</article></li>';

  return html;
}

function parseDisplayDate(date) {
  date = (date instanceof Date? date : new Date( Date.parse(date) ) );
  let display = date.getDate() + ' ' +
                ['January', 'February', 'March',
                 'April', 'May', 'June', 'July',
                 'August', 'September', 'October',
                 'November', 'December'][date.getMonth()] + ' ' +
                date.getFullYear();
  return display;
}

