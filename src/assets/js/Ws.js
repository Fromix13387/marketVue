import {User} from "../../main.js";
import Messages from "./Messages.js";
import {ref} from "vue";
export const client = new WebSocket('ws://localhost:8080')
export const connected = ref(false)

client.onopen = function () {
    connected.value = true
    console.log('Connect WebSocket')
}
client.onmessage = function (event) {
    const data = JSON.parse(event.data)

    if (data.user?.token) {
        localStorage.setItem('token', data.user.token)
        for (const key in data) User[key] = data[key]
        User.auth = true
    }
    else User.auth = false
    console.log(data)

    if (data.method === 'getUsers') Messages.users = data.data
    else if (data.method === 'getMessages') Messages.changeChat(data.receiver, data.data)
};
client.onclose = function (event) {
    connected.value = false
    console.log('Connection closed')
}