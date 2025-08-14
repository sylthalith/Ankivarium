import { sendRequest } from "./utils/request.js";

async function main() {
    if (!data) {
        try {
            data = await getCard()
        } catch (error) {
            alert(error.message)
            return
        }
    }

    nextData = getCard()

    refreshElementsText()
}

async function getCard() {
    try {
        return await sendRequest(`study/${deckId}`)
    } catch (error) {
        throw new Error(error.message || 'Не удалось загрузить карточку')
    }
}

function refreshElementsText() {
    frontText.textContent = data.front

    progress.value = data.cards_completed
    progress.max = data.cards_due
    progressText.textContent = `Карточка ${data.cards_completed} из ${data.cards_due}`

    setTimeout(() => {
        backText.textContent = data.back

        again.querySelector('.time').textContent = `${data.intervals.again}д`
        hard.querySelector('.time').textContent = `${data.intervals.hard}д`
        good.querySelector('.time').textContent = `${data.intervals.good}д`
        easy.querySelector('.time').textContent = `${data.intervals.easy}д`
    }, 350)
}

async function submit(rating) {
    let response
    try {
        response = await sendRating(data.card_id, rating)
    } catch (error) {
        alert(error.message)
        return
    }

    try {
        nextData = await nextData
    } catch (error) {
        alert(error.message)
        return
    }

    if (!nextData) {
        if (data.intervals[rating] >= 1) {
            window.location.href = '/'
        } else {
            data.intervals = response.intervals
            data.cards_completed = response.cards_completed
            data.cards_due = response.cards_due

            card.classList.remove('flipped')
            main()
        }

    } else {
        data = nextData
        data.cards_completed = response.cards_completed
        data.cards_due = response.cards_due

        card.classList.remove('flipped')
        main()
    }
}

async function sendRating(cardId, rating) {
    try {
        return await sendRequest(`study/${cardId}`, 'POST', {'rating': rating})
    } catch (error) {
        throw new Error(error.message || 'Ошибка при отправке данных')
    }
}

const deckId = document.querySelector('meta[name="deck-id"]').content
const card = document.querySelector('.card')
const front = document.querySelector('.front')
const back = document.querySelector('.back')
const frontText = document.getElementById('front-text')
const backText = document.getElementById('back-text')
const again = document.getElementById('again')
const hard = document.getElementById('hard')
const good = document.getElementById('good')
const easy = document.getElementById('easy')
const progress = document.querySelector('progress')
const progressText = document.getElementById('progress-text')

document.getElementById('show').addEventListener('click', () => {
    card.classList.add('flipped')
})

document.getElementById('back-actions').addEventListener('click', (event) => {
    const btn = event.target.closest('button')
    if (!btn) return

    switch (btn.id) {
        case 'again': return submit('again')
        case 'hard':  return submit('hard')
        case 'good':  return submit('good')
        case 'easy':  return submit('easy')
    }
})

let data = null
let nextData = null

main()
