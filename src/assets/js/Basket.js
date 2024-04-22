import {reactive, ref} from "vue";

class Basket {
    basket = JSON.parse(localStorage.getItem('basket')) ?? []

    addBasket(product) {
        if (typeof product !== 'object') product = {}
        this.basket.push(product)
        localStorage.setItem('basket', JSON.stringify(this.basket))
        return true
    }
    removeProduct(id) {
        if (this.getCountProduct(id) !== 0) {
            this.basket.splice(this.basket.indexOf(this.getProduct(id)[0]), 1)
            localStorage.setItem('basket', JSON.stringify(this.basket))
        }
    }
    deleteProduct(id) {
        this.basket = this.basket.filter(el => el.id !== +id)
        localStorage.setItem('basket', JSON.stringify(this.basket))
    }
    getProduct(id) {
        return this.basket.filter(el => el.id === +id)
    }
    getCountProduct(id) {
        return this.getProduct(id).length
    }
    getAllSumProducts() {
        return this.basket.reduce((acc,el) => acc + +el.price, 0)
    }
    clear() {

    }
    filterObject = () => {
        const table = {}
        return this.basket.filter(({id}) =>!table[id] && (table[id] = 1)).sort((a,b) => a.id - b.id);
    }
}
const basket = reactive(new Basket())

export default basket
