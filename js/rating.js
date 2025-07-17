$(function() {
  $('#formReview').on('submit', function(e) {
      e.preventDefault();

      let rating = $('#rating').val();
      if (!rating || rating < 1 || rating > 5) {
          showMessage('Por favor, selecione uma nota entre 1 e 5 estrelas.', 'error');
          return;
      }

      $.ajax({
          url: 'rating.php',
          method: 'POST',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(res) {
              if (res.success) {
                  showMessage(res.message, 'success');
                  $('#formReview')[0].reset();
              } else {
                  showMessage(res.message, 'error');
              }
          },
          error: function() {
              showMessage('Erro ao enviar avaliação.', 'error');
          }
      });
  });

  function showMessage(text, type) {
      $('#message')
          .stop(true, true)
          .hide()
          .removeClass('success error')
          .addClass(type)
          .text(text)
          .fadeIn();
  }
});
