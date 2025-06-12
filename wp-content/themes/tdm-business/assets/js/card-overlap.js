document.addEventListener('DOMContentLoaded', () => {
    const card = document.querySelector('.card');
    const controls = document.querySelector('.controls');
    const btns = controls.querySelectorAll('.overlap-arrow'); // This will now correctly find the elements

    const disableBtns = () => {
        for (const btn of btns) btn.setAttribute('disabled', true);
    };

    const enableBtns = () => {
        for (const btn of btns) btn.removeAttribute('disabled');
    };

    for (const btn of btns) {
        btn.addEventListener('click', e => {
            disableBtns();
            requestAnimationFrame(() => {
                card.className = 'card';
                card.classList.add(btn.getAttribute('data-anim'));
                card.lastElementChild.addEventListener('animationend', () => {
                    const first = card.firstElementChild;
                    requestAnimationFrame(() => {
                        card.removeChild(first);
                        card.appendChild(first);
                        card.className = 'card';
                    });
                    enableBtns();
                }, { once: true });
            });
        });
    }

    // IIFE for Button Click Animation
    (() => {
        'use strict';

        const buttons = document.querySelectorAll('.overlap-arrow');
        const clickedClass = '-js-clicked';

        const btn_clicked = e => {
            const btn = e.target;
            btn.classList.add(clickedClass);
            btn.addEventListener('animationend', () => {
                btn.classList.remove(clickedClass);
            }, { once: true });
            btn.focus();
        };

        Object.values(buttons).forEach(btn => {
            btn.addEventListener('click', btn_clicked);
            btn.addEventListener('blur', e => {
                e.target.classList.remove(clickedClass);
            });
        });
    })(); // Immediately invoke the function
});