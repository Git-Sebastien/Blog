let app = new Vue({
    el: "#app",
    data: {
        message: "Hello World",
        user: "Seb",
        produits: ['pizza', 'burger', 'cheese', 'tacos'],
        commande: []
    },
    methods: {
        commander: (produit) => {
            console.log(produit);
        }
    }
})