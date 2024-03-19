const basket = new Proxy(JSON.parse(localStorage.getItem('basket')) ?? [], {
    set(target, prop, newValue, receiver) {
        if (typeof newValue === 'object'){
            console.log(receiver)
            target[prop] = newValue
            localStorage.setItem('basket', JSON.stringify(receiver))
            return true
        }
        return false
    },
    defineProperty(target, prop, attributes) {
        delete target[prop]
        localStorage.setItem('basket', JSON.stringify(attributes))
        return true
    }
})


const addBasket = (product) => {
    console.log(product)
    const data = JSON.parse(localStorage.getItem('basket')) ?? []
    localStorage.setItem('basket', [...data, product].toString())
}
const removeBasket = (product) => {

}

export {
    basket, removeBasket, addBasket
}