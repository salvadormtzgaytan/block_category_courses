// This file is part of Moodle: https://moodle.org/
// @module block_category_courses/dashboard

/**
 * Maneja el clic (o enter/espacio) en la tarjeta de categoría.
 * Envía el categoryid por POST hacia view_courses.php
 * @param {Event} e - El evento de clic o teclado
 */
function handleCardClick(e) {
    // No navegar si se hace clic en un elemento interactivo interno
    if (e.target.closest('a, button, input, select, textarea')) {
        return;
    }

    const card = this;
    const categoryId = card.dataset.categoryId;
    const clickBehavior = card.dataset.clickBehavior || 'category';
    const linkElement = card.querySelector('.card-link');
    const url = linkElement ? linkElement.dataset.url : null;

    if (clickBehavior === 'courses') {
        e.preventDefault();

        // --- Crear formulario invisible para POST ---
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = M.cfg.wwwroot + '/blocks/category_courses/view_courses.php';

        const cat = document.createElement('input');
        cat.type = 'hidden';
        cat.name = 'categoryid';
        cat.value = categoryId;
        form.appendChild(cat);

        // Opcional: añadir sesskey si tu página valida tokens
        // const sk = document.createElement('input');
        // sk.type = 'hidden';
        // sk.name = 'sesskey';
        // sk.value = M.cfg.sesskey;
        // form.appendChild(sk);

        document.body.appendChild(form);
        form.submit();
        return;
    }

    // Comportamiento normal (navegación con URL)
    if (url) {
        e.preventDefault();
        card.classList.add('card-clicked');
        setTimeout(() => {
            window.location.href = url;
        }, 150);
    }
}

/**
 * Inicializa la funcionalidad de tarjetas de categorías.
 */
export const init = () => {
    const cards = document.querySelectorAll('.category-card');

    cards.forEach((card) => {
        // Accesibilidad
        card.setAttribute('role', 'button');
        card.setAttribute('tabindex', '0');

        // Click handler
        card.addEventListener('click', handleCardClick);

        // Teclado (Enter o espacio)
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                handleCardClick.call(card, e);
            }
        });
    });
};
