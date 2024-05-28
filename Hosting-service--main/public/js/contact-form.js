window.addEventListener('DOMContentLoaded', () => {
    initOnFormSubmit();
});

function initOnFormSubmit() {
    const form = document.querySelector('#contactUsModal form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        sendData(form);
    });
}

async function sendData(form) {
    try {
        const response = await fetch(form.getAttribute('action'), {
            method: 'POST',
            body: new FormData(form),
        });

        if (response.ok) {
            const newHtml = await response.text();
            const divElement = document.createElement('div');
            divElement.innerHTML = newHtml;
            const newModalBody = divElement.querySelector('#contactUsModal .modal-body');
            const oldModalBody = document.querySelector('#contactUsModal .modal-body');

            if (newModalBody) {
                oldModalBody.innerHTML = newModalBody.innerHTML;
            } else {
                oldModalBody.innerHTML = 'Error occurred. Please try again later';
            }

            initOnFormSubmit();
        } else {
            throw new Error('Network response was not ok.');
        }
    } catch (error) {
        document.querySelector('#contactUsModal .modal-body').innerHTML = 'Error occurred. Please try again later';
    }
}
