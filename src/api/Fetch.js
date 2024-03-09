export const Fetch = (body, url = 'index.php') => {
    let formData = new FormData()
    for (let key in body) {
        formData.append(key, body[key])
    }
    return fetch("http://localhost:4000/" + url, {
        method: 'POST',
        body: formData
    }).then(res => res.json())
}