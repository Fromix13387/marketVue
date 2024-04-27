import {WebSocketServer} from 'ws'
import Db from "./classes/Db.js";
import ErrorCustom from "./classes/ErrorCustom.js";
import {checkAuth} from "./api/Fetch.js";
import {createLogger} from "vite";

const wss = new WebSocketServer({port: 8080})
const db = new Db()


wss.on('connection', (ws, req) => {
    ws.on('error', console.error)
    ws.on('message',async function (data) {
        data = JSON.parse(data)
        console.log(data)
        const {method, username, user_token} = data
        let message = {}
        const checkUser = await checkAuth(user_token)

        if (!checkUser.token) return ws.send(JSON.stringify(ErrorCustom.errorAuthorization()))

        if (method === 'getUsers') {
            const [rows] = await db.getUsers(username)
            message.data = rows.filter(el => el.username !== checkUser.username)
                .map(el => {
                return {username: el.username, image: el.image, fullname: el.fullname, id: el.id}
            })
        }
        else if (method === 'getMessages') {
            const [rows] = await db.getMessages(data.sender_name,data.receiver.username)
            console.log(rows)
            message = {data: rows, receiver: data.receiver}
        }
        else if (method === 'sendMessage') {
            if (data.message && data.message.length === 0) return ws.send(JSON.stringify(ErrorCustom.errorMessage()))

            await db.saveMessage(data.sender_id, data.receiver_id, message)
            message = {data: true}
        }
        else message = {...ErrorCustom.errorNotFound()}
        ws.send(JSON.stringify({user: checkUser, ...message, method}))
    })
})
