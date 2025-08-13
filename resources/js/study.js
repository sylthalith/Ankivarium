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

    console.log('Получена карточка')
    console.log(data)

    nextData = getCard()

    refreshProgress()

    showFront()
}

async function getCard() {
    try {
        return await sendRequest(`study/${deckId}`)
    } catch (error) {
        throw new Error(error.message || 'Не удалось загрузить карточку')
    }
}

function refreshProgress() {
    progress.value = data.cards_completed
    progress.max = data.cards_due
    progressText.textContent = `Карточка ${data.cards_completed} из ${data.cards_due}`
}

function showFront() {
    text.textContent = data.front

    text.classList.remove('hidden')
    show.classList.remove('hidden')
}

function showBack() {
    text.textContent = data.back

    setIntervalsForBtns()

    show.classList.add('hidden')

    showDifficultyBtns()
}

function setIntervalsForBtns() {
    again.querySelector('.time').textContent = `${data.intervals.again}д`
    hard.querySelector('.time').textContent = `${data.intervals.hard}д`
    good.querySelector('.time').textContent = `${data.intervals.good}д`
    easy.querySelector('.time').textContent = `${data.intervals.easy}д`
}

function showDifficultyBtns() {
    again.classList.remove('hidden')
    hard.classList.remove('hidden')
    good.classList.remove('hidden')
    easy.classList.remove('hidden')
}

function hideDifficultyBtns() {
    again.classList.add('hidden')
    hard.classList.add('hidden')
    good.classList.add('hidden')
    easy.classList.add('hidden')
}

async function submit(rating) {
    let response
    try {
        response = await sendRating(data.card_id, rating)
    } catch (error) {
        alert(error.message)
        return
    }

    console.log('Получены данные при ответе')
    console.log(response)

    try {
        nextData = await nextData
    } catch (error) {
        alert(error.message)
        return
    }

    console.log('Следующая карточка')
    console.log(nextData)

    if (!nextData) {
        if (data.intervals[rating] >= 1) {
            window.location.href = '/'
        } else {
            data.intervals = response.intervals
            data.cards_completed = response.cards_completed
            data.cards_due = response.cards_due

            hideDifficultyBtns()
            await main()
        }

    } else {
        data = nextData
        data.cards_completed = response.cards_completed
        data.cards_due = response.cards_due

        hideDifficultyBtns()
        await main()
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
const text = document.querySelector('.card-text')
const show = document.getElementById('show')
const again = document.getElementById('again')
const hard = document.getElementById('hard')
const good = document.getElementById('good')
const easy = document.getElementById('easy')
const progress = document.querySelector('progress')
const progressText = document.getElementById('progress-text')

document.querySelector('.actions').addEventListener('click', (event) => {
    const btn = event.target.closest('button')
    if (!btn) return

    switch (btn.id) {
        case 'show':  return showBack()
        case 'again': return submit('again')
        case 'hard':  return submit('hard')
        case 'good':  return submit('good')
        case 'easy':  return submit('easy')
    }
})

let data = null
let nextData = null

main()
