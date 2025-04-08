
document.addEventListener('DOMContentLoaded', function() {
// Handle vote submission with confirmation
const voteForms = document.querySelectorAll('.vote-form');

voteForms.forEach(form => {
   form.addEventListener('submit', async function(e) {
       e.preventDefault();
       
       const candidateId = this.querySelector('input[name="candidate_id"]').value;
       const candidateName = this.closest('.card-body').querySelector('.card-title').textContent;
       const submitButton = this.querySelector('button[type="submit"]');
       
       // Store original button text
       const originalButtonText = submitButton.innerHTML;
       
       try {
           // Show confirmation dialog
           const confirmation = await Swal.fire({
               title: 'Confirm Your Vote',
               html: `
                   <div class="text-center">
                       <i class="fas fa-user-check fa-4x text-primary mb-3"></i>
                       <h4>You are voting for:</h4>
                       <h3 class="text-primary fw-bold my-3">${candidateName}</h3>
                       <p class="text-muted">This action is permanent and cannot be changed</p>
                   </div>
               `,
               icon: 'question',
               showCancelButton: true,
               confirmButtonColor: '#008751',
               cancelButtonColor: '#6c757d',
               confirmButtonText: 'Yes, Submit Vote',
               cancelButtonText: 'Cancel',
               focusConfirm: false,
               allowOutsideClick: false
           });
           
           if (!confirmation.isConfirmed) {
               return;
           }
           
           // Disable button and show loading state
           submitButton.disabled = true;
           submitButton.innerHTML = `
               <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
               Processing...
           `;
           
           // Submit the form data via AJAX
           const response = await fetch(this.action, {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/x-www-form-urlencoded',
                   'X-Requested-With': 'XMLHttpRequest',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
               },
               body: new URLSearchParams(new FormData(this))
           });
           
           const data = await response.json();
           
           if (!response.ok) {
               throw new Error(data.message || 'Failed to submit vote');
           }
           
           // Show success message and reload
           await Swal.fire({
               title: 'Vote Submitted!',
               text: `Your vote for ${candidateName} has been recorded.`,
               icon: 'success',
               confirmButtonColor: '#008751',
               willClose: () => {
                   window.location.reload();
               }
           });
           
       } catch (error) {
           console.error('Vote submission error:', error);
           
           // Show error message
           await Swal.fire({
               title: 'Vote Failed',
               text: error.message || 'An error occurred while submitting your vote',
               icon: 'error',
               confirmButtonColor: '#d33'
           });
           
           // Reset button state
           submitButton.disabled = false;
           submitButton.innerHTML = originalButtonText;
       }
   });
});

// Animate cards on scroll
const animateCards = () => {
   const cards = document.querySelectorAll('.candidate-card');
   const windowHeight = window.innerHeight;
   const triggerPoint = windowHeight * 0.8;
   
   cards.forEach(card => {
       const cardPosition = card.getBoundingClientRect().top;
       
       if (cardPosition < triggerPoint) {
           card.classList.add('show');
       }
   });
};

// Initial animation on load
animateCards();

// Animate on scroll
window.addEventListener('scroll', animateCards);
});


