import { sendRequest } from "./utils/request.js";

document.querySelectorAll('.delete-btn').forEach(button => {
    let card = button.closest('.card')
    button.addEventListener('click', async () => {
        await deleteCard(card)
    })
});

async function deleteCard(card) {
    let cardId = card.getAttribute('data-card-id')
    if (!cardId) return

    if (!confirm('Вы уверены, что хотите удалить эту карточку?')) return

    try {
        await sendRequest(`/cards/${cardId}`, 'DELETE')
        card.remove()
    } catch (error) {
        alert(error || 'Произошла ошибка при удалении карточки')
    }
}
