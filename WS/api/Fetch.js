
const Fetch = (body, token, url = 'index.php') => {
    let formData = new FormData()
    for (let key in body) {
        formData.append(key, body[key])
    }

    return fetch('http://localhost:4000/' + url, {
        method: 'POST',
        body: formData,
        headers: token ? {
            'Authorization': token,
        } : undefined
    }).then(res => res.json())
}

const checkAuth = async (token) => {
    return Fetch({method: 'checkAuth'}, token)
}
export {
    checkAuth
}