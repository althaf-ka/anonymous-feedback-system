
function showToast(message, type = 'info') {
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `<div class="toast-content"><span>${message}</span></div>`;

  Object.assign(toast.style, {
    position: 'fixed',
    top: '2rem',
    right: '2rem',
    padding: '1rem 1.5rem',
    borderRadius: '12px',
    color: 'white',
    fontWeight: '600',
    zIndex: '9999',
    transform: 'translateX(100%)',
    transition: 'transform 0.3s ease',
    background: type === 'success' ? 'var(--color-success, #22C55E)' : 'var(--color-error, #EF4444)',
    boxShadow: '0 8px 25px rgba(0,0,0,0.15)'
  });

  document.body.appendChild(toast);

  setTimeout(() => toast.style.transform = 'translateX(0)', 100);
  setTimeout(() => {
    toast.style.transform = 'translateX(100%)';
    setTimeout(() => document.body.removeChild(toast), 300);
  }, 3000);
}


window.showToast = showToast;
