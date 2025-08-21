export async function sendRequest(url, method = 'GET', body = null) {
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
            console.log(await response.text())
            throw new Error('Ошибка на сервере')
        }

        if (response.status === 204) {
            return null
        }

        return await response.json()
    } catch (error) {
        throw error
    }
}
