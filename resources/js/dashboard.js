import playIcon from '../images/Play.svg'
import plusIcon from '../images/Plus.svg'
import editIcon from '../images/EditOutlined.svg'
import deleteIcon from '../images/DeleteOutlined.svg'

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

async function sendRequest(url, method, body = null) {
    const init = {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
    }

    if (body && method !== 'GET') {
        init.body = JSON.stringify(body)
    }

    try {
        const response = await fetch(url, init)

        if (!response.ok) {
            throw new Error('Ошибка на сервере')
        }

        return await response.json()
    } catch (error) {
        throw error
    }
}

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
    div.innerHTML = deckHTML(data)

    const decks = document.querySelector('.decks')
    decks.appendChild(div)
}

function deckHTML(data) {
    return `
        <div class="deck-title">
            <h3>${data.deck_name}</h3>
        </div>
        <div class="to-study">
            0 карточек
        </div>
        <div class="progress-bar">
            <progress max="0" value="0"></progress>
        </div>
        <div class="progress">
            Изучено: 0/0 (0%)
        </div>
        <div class="actions">
            <button class="btn action-btn study-btn">
                <img src="${playIcon}">
                Учить
            </button>
            <button class="btn action-btn add-btn">
                <img src="${plusIcon}">
                Добавить
            </button>
            <button class="btn action-btn edit-btn">
                <img src="${editIcon}">
                Изменить
            </button>
            <button class="btn action-btn delete-btn">
                <img src="${deleteIcon}">
                Удалить
            </button>
        </div>
    `
}
