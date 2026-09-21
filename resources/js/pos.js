document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.product-card');

    cards.forEach(card => {
        card.addEventListener('click', () => {
            card.classList.add('ring-2', 'ring-blue-500');

            setTimeout(() => {
                card.classList.remove('ring-2', 'ring-blue-500');
            }, 300);
        });
    });
});