import { sendRequest } from "./utils/request.js";
import { deckHTML } from "./utils/deck.js";

document.querySelector('.new-deck').addEventListener('click', async () => {
    let deckName = prompt("Введите название колоды:")
    if (!deckName) return

    try {
        const response = await sendRequest('/decks', 'POST', {'name': deckName})
        showDeck(response)
    } catch(error) {
        alert(error.message || 'Не удалось создать колоду')
    }
})

document.querySelector('.decks').addEventListener('click', async (event) => {
    const btn = event.target.closest('button');
    if (!btn) return

    let deck = btn.closest('.deck')
    if (!deck) return

    if (btn.classList.contains('edit-btn')) {
        await editBtn(deck)
    }

    if (btn.classList.contains('delete-btn')) {
        await deleteBtn(deck)
    }
})

async function editBtn(deck){
    let deckId = deck.getAttribute('data-deck-id')
    if (!deckId) return

    const newDeckName = prompt("Введите новое название колоды:")

    if (!newDeckName) return

    try {
        const response = await sendRequest(`/decks/${deckId}`, 'PATCH', {'new_deck_name': newDeckName})

        let deckTitle = deck.querySelector('.deck-title').querySelector('h3')
        if (deckTitle) {
            deckTitle.textContent = response.new_deck_name;
        }
    } catch (error) {
        alert(error.message || 'Не удалось изменить колоду')
    }
}

async function deleteBtn(deck){
    if (!confirm('Вы уверены, что хотите удалить эту колоду?')) return

    let deckId = deck.getAttribute('data-deck-id')
    if (!deckId) return

    try {
        await sendRequest(`decks/${deckId}`, 'DELETE')
        deck.remove()
    } catch (error) {
        alert(error.message || 'Не удалось удалить колоду')
    }
}

function showDeck(data) {
    const div = document.createElement('div')
    div.classList.add('deck')
    div.setAttribute('data-deck-id', data.deck_id)
    div.innerHTML = deckHTML()
    div.querySelector('.deck-title').querySelector('h3').textContent = data.deck_name

    const decks = document.querySelector('.decks')
    decks.appendChild(div)
}
