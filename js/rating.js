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

document.addEventListener('DOMContentLoaded', () => {
    loadReviews();
  });
  
  function loadReviews() {
    fetch('fetch_reviews.php')
      .then(res => res.json())
      .then(data => {
        if(data.error) {
          console.error('Erro:', data.error);
          return;
        }
        
        const container = document.getElementById('reviewsContainer');
        container.innerHTML = ''; // limpa
  
        if (data.length === 0) {
          container.innerHTML = '<p>Nenhuma avaliação disponível.</p>';
          return;
        }
  
        data.forEach(review => {
          const div = document.createElement('div');
          div.classList.add('review');
  
          // Monta estrelas (ex: ★★★☆☆)
          const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
  
          div.innerHTML = `
            <strong>${escapeHtml(review.user_name)}</strong> - <em>${new Date(review.review_date).toLocaleString()}</em><br>
            <span class="stars">${stars}</span>
            <p>${escapeHtml(review.review_comment || '')}</p>
            <hr>
          `;
          container.appendChild(div);
        });
      })
      .catch(err => {
        console.error('Erro ao carregar avaliações:', err);
      });
  }
  
  // Função simples para escapar HTML e evitar XSS
  function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>"']/g, (m) => {
      switch (m) {
        case '&': return '&amp;';
        case '<': return '&lt;';
        case '>': return '&gt;';
        case '"': return '&quot;';
        case "'": return '&#039;';
        default: return m;
      }
    });
  }
  