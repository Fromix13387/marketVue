import {reactive} from "vue";
import {User} from "../../main.js";
import {client} from "./Ws.js";

class Messages {
    users = [];
    visibleModal = false;
    users_message = []
    messages = []
    receiver = 0

    getUsers(username) {
        client.send(JSON.stringify({
            method: 'getUsers',
            username,
            user_token: User.value.token
        }))
    }
    getMessages(receiver) {
        client.send(JSON.stringify({
            method: 'getMessages',
            sender_name: User.value.username,
            receiver,
            user_token: User.value.token
        }))
    }
    send_message(message) {
        console.log(message)
        client.send(JSON.stringify({
            method: 'sendMessage',
            sender_id: User.value.id,
            receiver_id: this.receiver.id,
            message,
            user_token: User.value.token
        }))
    }
    changeChat(user, messages) {
        const index = this.users_message.findIndex(el => el.id === user.id)
        if (index !== -1) {
            user = this.users_message[index]
            this.users_message.splice(index, 1)
        }
        this.users_message.unshift(user)

        this.receiver = user
        this.messages = messages
    }
}
export default reactive(new Messages())

