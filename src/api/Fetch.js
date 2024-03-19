import {defaultUrl} from "../main.js";

export const Fetch = (body, url = 'index.php') => {
    let formData = new FormData()
    for (let key in body) {
        formData.append(key, body[key])
    }
    const token = localStorage.getItem('token')
    return fetch(defaultUrl + url, {
        method: 'POST',
        body: formData,
        headers: token ? {
            'Authorization': token,
        } : undefined
    }).then(res => res.json())
}