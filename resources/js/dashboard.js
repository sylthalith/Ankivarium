import playIcon from '../images/Play.svg'
import plusIcon from '../images/Plus.svg'
import editIcon from '../images/EditOutlined.svg'
import deleteIcon from '../images/DeleteOutlined.svg'

const token = document.querySelector('meta[name="csrf-token"]').content

document.querySelector('.new-deck').addEventListener('click', createDeck)

async function createDeck() {
    const deckName = prompt("Введите название колоды:")

    if (!deckName) return

    const formData = new FormData()
    formData.append('name', deckName)
    formData.append('_token', token)

    const response = await fetch('/decks/create', {
        method: 'POST',
        body: formData
    })

    if (!response.ok) {
        alert('Ошибка при создании колоды')
        return
    }

    const data = await response.json()

    showDeck(data)
}

function showDeck(data) {
    const decks = document.querySelector('.decks')

    const div = document.createElement('div')
    div.classList.add('deck')
    div.setAttribute('data-deck-id', data.deck_id)
    div.innerHTML = newDeck(data)

    decks.appendChild(div)
}

function newDeck(data) {
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

document.querySelector('.decks').addEventListener('click', async (event) => {
    const btn = event.target.closest('button');
    if (!btn) return

    let deck = btn.closest('.deck')
    let deckId = deck.getAttribute('data-deck-id')
    if (!deckId) return

    if (btn.classList.contains('edit-btn')) {
        const newDeckName = prompt("Введите новое название колоды:")

        if(!newDeckName) return

        const formData = new FormData()
        formData.append('deck_id', deckId)
        formData.append('new_deck_name', newDeckName)
        formData.append('_token', token)

        const response = await fetch('decks/edit', {
            method: 'POST',
            body: formData
        })

        if (!response.ok) {
            alert('Ошибка при изменении колоды')
            return
        }

        let data = await response.json()

        let deckTitle = deck.querySelector('.deck-title').querySelector('h3')
        if (deckTitle) {
            deckTitle.textContent = data.new_deck_name;
        }
    }

    if (btn.classList.contains('delete-btn')) {
        if (!confirm('Вы уверены, что хотите удалить эту колоду?')) return

        const formData = new FormData()
        formData.append('deck_id', deckId)
        formData.append('_token', token)

        const response = await fetch('decks/delete', {
            method: 'POST',
            body: formData
        })

        if (!response.ok) {
            alert('Ошибка при удалении колоды')
            return
        }

        deck.remove()
    }
})
