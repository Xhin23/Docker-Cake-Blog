var form_errors =
{
  check: function() {
    var errors = false;
    $(".error-message").remove();

    var title = $("#title").val().length;
    if (title < 5)
    {
      errors = this.error('#title','Title must be longer than 5 characters.');
    }
    else if (title > 255)
    {
      errors = this.error('#title','Title must not be longer than 255 characters.');
    }
    if ($("#body").val().length < 10)
    {
      errors = this.error('#body','Body must be 10 characters or longer.')
    }
    return errors;
  },
  error: function(el,message)
  {
    $(el).after($('<div class="error-message">'+message+'</div>'));
    return true;
  }
}

function message(message) {
  var el = $('<div class="message success">'+message+'</div>');
  $("body").prepend(el);
  el.click(function() {
    $(this).slideUp({ done: function() {
      $(this).remove();
    }})
  });
}

$("#save-draft").click(function() {
  if (form_errors.check())
  {
    return;
  }
  var data = $("#alter-article").find('form').serialize()+'&'+$.param({id: _id});

  $.ajax({
    type: "POST",
    url: '/articles/save_draft',
    data: data,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
    },
    success: function(e) {
      message('Draft Saved');

      data = JSON.parse(e);
      _id = data.article_id;
    }
  })
});
