import mysql from 'mysql2/promise'
import configDb from "../config/configDb.js";
class Db {
    pool
    constructor() {
        this.pool = mysql.createPool({
            ...configDb,
            connectionLimit: 10,
            enableKeepAlive: true,
            keepAliveInitialDelay: 0,
        })
    }

    getUsers(username = '') {
        const res  = username.trim() === '' ? '%' : '%'+username+'%'
        return this.pool.execute('SELECT * FROM users WHERE fullname LIKE ?', [res])
    }
    getMessages(sender_name, receiver_name) {
        return this.pool.execute('SELECT * FROM messages JOIN users ON messages.sender_id = users.id or messages.receiver_id = users.id WHERE username = ? or username = ?', [sender_name, receiver_name])
    }
    saveMessage(sender_id, receiver_id, message) {
        return this.pool.execute('INSERT INTO messages (sender_id, receiver_id, content) VALUE (?,?,?)', [sender_id, receiver_id, message])
    }
}
export default Db
