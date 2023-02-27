const client = contentful.createClient({
    // This is the space ID. A space is like a project folder in Contentful terms
    space: "s9aemaw1w2dc",
    // This is the access token for this space. Normally you get both ID and the token in the Contentful web app
    accessToken: "NWfSreNtoti9XNNxgv0zusRGXAG_LiuhACfpWtvCOV0"
});

//console.log(client);

// variables
const cartBtn = document.querySelector('.cart-btn');
const closeCartBtn = document.querySelector('.close-cart');
const clearCartBtn = document.querySelector('.clear-cart');
const cartDOM = document.querySelector('.cart');
const cartOverlay = document.querySelector('.cart-overlay');
const cartItems = document.querySelector('.cart-items');
const cartTotal = document.querySelector('.cart-total');
const cartContent = document.querySelector('.cart-content');
const productsContent = document.querySelector('.products-center');
const productsDOM = document.querySelector('.products-center');
const topSellingProductsDOM = document.querySelector('.topselling-center');

// cart
let cart = [];
// buttons
let buttonsDOM = [];

// getting the products
class Products {
    async getProducts() {
        try {

            //const response = await client.getEntries();
            //console.log(response.items);

            let contentful = await client.getEntries({
                content_type: "storeProducts"
            });
            //console.log(contentful);

            //let result = await fetch('./products.json');
            //let data = await result.json();
            //return data;
            let products = contentful.items;
            //let products = data.items;
            products = products.map(item => {
                const {
                    id
                } = item.sys;
                const {
                    productName,
                    brand,
                    category,
                    supplier,
                    purchasePrice,
                    sellingPrice,
                    description,
                    specifications,
                    weight,
                    inventoryStatus,
                    tag
                } = item.fields;
                const image = item.fields.image.fields.file.url;
                return {
                    id,
                    productName,
                    brand,
                    category,
                    supplier,
                    sellingPrice,
                    description,
                    specifications,
                    weight,
                    inventoryStatus,
                    tag,
                    image
                };
            });
            return products;
        } catch (error) {
            console.log(error);
        }

    }
}

function number_format(val, decimals) {
    //Parse the value as a float value
    val = parseFloat(val);
    //Format the value w/ the specified number
    //of decimal places and return it.
    return val.toFixed(decimals);
}

// display products
class UI {
    displayProducts(products) {
        //console.log(products);
        let result = '';
        let topSellingResult = '';
        let statusBlocking = '';
        let btnText = '';
        let tag = '';

        products.forEach(product => {
            //if the tag is topselling, add a cart to the tagResult variable
            tag = product.tag;

            if (tag == 'topselling') {
                topSellingResult += `
<!--single top selling produt-->
                <article class="filterDiv show-card product card mx-0 store-product-card ${product.tag} ${product.category}">
                    <p class="card-text text-center p-1 rounded-pill text-truncate store-product-card-tag">${product.tag}</p>
                    <img src=${product.image} class="card-img-top img-fluid" alt="...">
                    <div class="card-body fixed-lr-logo-mesh-div-bg">
                        <hr>
                        <div class="card-body bg-transparent text-center p-0 mb-4">
                            <!--<div class="row align-items-center">
                                <div class="col-lg-4 text-center p-0">
                                    <button class="btn border-3 border-white p-2 rounded-pill store-product-card-buttons" data-id=${product.id}>
                                        <span class="fas fa-minus" style="font-size: 25px"></span>
                                    </button>
                                </div>
                                <div class="col-lg-4 text-center item-amount" style="font-size: 50px">
                                    1
                                </div>
                                <div class="col-lg-4 text-center p-0">
                                    <button class="btn border-3 border-white p-2 rounded-pill store-product-card-buttons" data-id=${product.id}>
                                        <span class="fas fa-plus" style="font-size: 25px"></span>
                                    </button>
                                </div>
                            </div>-->

                            <button class="btn text-center p-2 rounded-pill store-product-card-buttons bag-btn" data-id=${product.id} ${statusBlocking}>
                                <!--Add to Shopping Bag <i class="fas fa-shopping-bag"></i>-->
                                ${btnText}
                            </button>
                        </div>
    
                        <h4 class="p-2 mb-4 text-center rounded-pill" style="color: white; background: #E43D40;">R ` + number_format(product.sellingPrice, 2) + `</h4>
                        
                        <h5 class="card-title mb-2 text-center">${product.productName}</h5>
                        
                        <p>
                            <a class="btn store-product-card-buttons rounded-pill px-4" data-toggle="collapse" href="#toggle-product-details" role="button" aria-expanded="false" aria-controls="toggle-product-details">
                                <span class="fas fa-eye"></span> Details
                            </a>
                        </p>

                        <div class="collapse" id="toggle-product-details">
                            <div class="card card-body border-0 shadow" style="border-radius: 25px">
                                <p class="card-text text-dark">
                                    ${product.description}
                                </p>

                                <p class="card-text text-dark product-card-specs">Specs:<br>
                                    ${product.specifications}
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
                <!--end of single top selling produt-->
            `;
            }

            //the If statement will disable the add to bag buttons if the inventory status is soldout
            if (product.inventoryStatus == 'soldout') {
                statusBlocking = "disabled";
                btnText = 'Sold Out <i class="fas fa-times"></i>';
            } else {
                statusBlocking = "";
                btnText = 'Add to Shopping Bag <i class="fas fa-shopping-bag"></i>';
            }
            
            result += `
                <!--single produt-->
                <article class="filterDiv show-card product card mx-0 store-product-card ${product.tag} ${product.category}">
                    <p class="card-text text-center p-1 rounded-pill text-truncate store-product-card-tag">${product.tag}</p>
                    <img src=${product.image} class="card-img-top img-fluid" alt="...">
                    <div class="card-body fixed-lr-logo-mesh-div-bg">
                        <hr>
                        <div class="card-body bg-transparent text-center p-0 mb-4">
                            <!--<div class="row align-items-center">
                                <div class="col-lg-4 text-center p-0">
                                    <button class="btn border-3 border-white p-2 rounded-pill store-product-card-buttons" data-id=${product.id}>
                                        <span class="fas fa-minus" style="font-size: 25px"></span>
                                    </button>
                                </div>
                                <div class="col-lg-4 text-center item-amount" style="font-size: 50px">
                                    1
                                </div>
                                <div class="col-lg-4 text-center p-0">
                                    <button class="btn border-3 border-white p-2 rounded-pill store-product-card-buttons" data-id=${product.id}>
                                        <span class="fas fa-plus" style="font-size: 25px"></span>
                                    </button>
                                </div>
                            </div>-->

                            <button class="btn text-center p-2 rounded-pill store-product-card-buttons bag-btn" data-id=${product.id} ${statusBlocking}>
                                <!--Add to Shopping Bag <i class="fas fa-shopping-bag"></i>-->
                                ${btnText}
                            </button>
                        </div>
    
                        <h4 class="p-2 mb-4 text-center rounded-pill" style="color: white; background: #E43D40;">R ` + number_format(product.sellingPrice, 2) + `</h4>
                        
                        <h5 class="card-title mb-2 text-center">${product.productName}</h5>
                        
                        <p>
                            <a class="btn store-product-card-buttons rounded-pill px-4" data-toggle="collapse" href="#toggle-product-details" role="button" aria-expanded="false" aria-controls="toggle-product-details">
                                <span class="fas fa-eye"></span> Details
                            </a>
                        </p>

                        <div class="collapse" id="toggle-product-details">
                            <div class="card card-body border-0 shadow" style="border-radius: 25px">
                                <p class="card-text text-dark">
                                    ${product.description}
                                </p>

                                <p class="card-text text-dark product-card-specs">Specs:<br>
                                    ${product.specifications}
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
                <!--end of single produt-->
            `;
        });
        
        //add the cards to the .Store catalogue
        topSellingProductsDOM.innerHTML = topSellingResult;
        
        //add the cards to the .Store catalogue
        productsDOM.innerHTML = result;
    }

    getBagButtons() {
        const buttons = [...document.querySelectorAll(".bag-btn")];
        buttonsDOM = buttons;
        buttons.forEach(button => {
            let id = button.dataset.id;
            let inCart = cart.find(item => item.id === id);
            if (inCart) {
                button.innerHTML = `<i class="fas fa-check-circle"></i> Added to Shopping Bag`;
                button.disable = true;
            } else {
                button.addEventListener('click', (event) => {
                    //alert("GetBagButtons");
                    event.target.innerHTML = `<i class="fas fa-check-circle"></i> Added to Shopping Bag`;
                    event.target.disabled = true;
                    // get product from products
                    let cartItem = {
                        ...Storage.getProduct(id),
                        amount: 1
                    };

                    // add product to the cart
                    cart = [...cart, cartItem];

                    // save cart in local storage
                    Storage.saveCart(cart);
                    // set cart values
                    this.setCartValues(cart);
                    // display cart item
                    this.addCartItem(cartItem);
                    // show the cart
                    //this.showCart();
                });
            }
        });
    }
    setCartValues(cart) {
        let tempTotal = 0;
        let itemsTotal = 0;

        cart.map(item => {
            tempTotal += item.sellingPrice * item.amount;
            itemsTotal += item.amount;
        });
        cartTotal.innerHTML = parseFloat(tempTotal.toFixed(2));
        //cartItems.innerText = itemsTotal;
        //console.log(cartTotal, cartItems);

        let elems = document.getElementsByClassName('cart-items');

        [].slice.call(elems).forEach(function (elems) {
            elems.innerText = itemsTotal;
        });
    }
    addCartItem(item) {
        const li = document.createElement('li');

        li.classList.add('list-group-item');
        li.classList.add('bg-transparent');
        li.classList.add('border-white');
        li.classList.add('cart-item');

        li.innerHTML = `
                <span class="remove-item" style="cursor: pointer" data-id=${item.id}><i class="fas fa-times"></i></span>
                
                <p>R ${item.sellingPrice} - ${item.productName}</p>
                <hr>
                <div class="row align-items-center">
                    <div class="col text-center p-0">
                        <button class="btn border-3 border-white p-2 rounded-pill store-product-card-buttons" data-id=${item.id}>
                            <span class="fas fa-minus" style="font-size: 25px" data-id=${item.id}></span>
                        </button>
                    </div>
                    <div class="col text-center item-amount" style="font-size: 50px">
                        <p class="item-amount">${item.amount}</p>
                    </div>
                    <div class="col text-center p-0">
                        <button class="btn border-3 border-white p-2 rounded-pill store-product-card-buttons" data-id=${item.id}>
                            <span class="fas fa-plus" style="font-size: 25px" data-id=${item.id}></span>
                        </button>
                    </div>
                </div>`;

        cartContent.appendChild(li);
        //console.log(cartContent);
    }

    setupAPP() {
        cart = Storage.getCart();
        this.setCartValues(cart);
        this.populateCart(cart);
        //cartBtn.addEventListener('click', this.showCart);
        //closeCartBtn.addEventListener('click', this.hideCart);
    }
    populateCart(cart) {
        cart.forEach(item => this.addCartItem(item));
    }
    /*showCart() {
        cartOverlay.classList.add('transparentBcg');
        cartDOM.classList.add('showCart');
    }*/
    /*hideCart() {
        cartOverlay.classList.remove('transparentBcg');
        cartDOM.classList.remove('showCart');
    }*/
    cartLogic() {
        // clear cart button
        clearCartBtn.addEventListener('click', () => {
            this.clearCart();
        });
        // cart functionality
        cartContent.addEventListener('click', event => {
            if (event.target.classList.contains('remove-item')) {
                alert("remove item from cart");
                let removeItem = event.target;
                //console.log(removeItem);
                let id = removeItem.dataset.id;
                cartContent.removeChild(removeItem.parentElement.parentElement)
                this.removeItem(id);
            } else if (event.target.classList.contains("fa-plus")) {
                let addAmount = event.target;
                let id = addAmount.dataset.id;
                let tempItem = cart.find(item => item.id === id);

                tempItem.amount = tempItem.amount + 1;
                Storage.saveCart(cart);
                this.setCartValues(cart);
                addAmount.nextElementSibling.innerText = tempItem.amount;
            } else if (event.target.classList.contains("fa-minus")) {
                let lowerAmount = event.target;
                let id = lowerAmount.dataset.id;
                let tempItem = cart.find(item => item.id === id);

                tempItem.amount = tempItem.amount - 1;
                if (tempItem.amount > 0) {
                    //update values
                    Storage.saveCart(cart);
                    this.setCartValues(cart);
                    lowerAmount.previousElementSibling.innerText = tempItem.amount;
                } else {
                    cartContent.removeChild(lowerAmount.parentElement.parentElement.parentElement.parentElement);
                    this.removeItem(id);
                }
            }
        });
    }

    clearCart() {
        let cartItems = cart.map(item => item.id);
        //console.log(cartItems);
        cartItems.forEach(id => this.removeItem(id));
        //console.log(cartContent.children);
        while (cartContent.children.length > 0) {
            cartContent.removeChild(cartContent.children[0])
        }
        //this.hideCart();
    }
    removeItem(id) {
        cart = cart.filter(item => item.id !== id);
        this.setCartValues(cart);
        Storage.saveCart(cart);
        let button = this.getSingleButton(id);
        button.disabled = false;
        button.innerHTML = `Add to Shopping Bag <i class="fas fa-shopping-bag"></i>`;
    }
    getSingleButton(id) {
        return buttonsDOM.find(button => button.dataset.id === id);
    }
}

// local storage
class Storage {
    static saveProducts(products) {
        localStorage.setItem("products", JSON.stringify(products));
    }

    static getProduct(id) {
        let products = JSON.parse(localStorage.getItem('products'));
        return products.find(product => product.id === id);
    }

    static saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart))
    }

    static getCart() {
        return localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const ui = new UI();
    const products = new Products();
    // setup app
    ui.setupAPP();

    // get all products
    products.getProducts().then(products => {
        ui.displayProducts(products);
        Storage.saveProducts(products);
    }).then(() => {
        ui.getBagButtons();
        ui.cartLogic();
    });
});


function filterSelection(c) {
    //alert(c);
    var x, i;
    x = document.getElementsByClassName("filterDiv");
    if (c == "all") c = "";
    // Add the "show" class (display:block) to the filtered elements, and remove the "show" class from the elements that are not selected
    for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show-card");
        if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show-card");
    }
}

// Show filtered elements
function w3AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        if (arr1.indexOf(arr2[i]) == -1) {
            element.className += " " + arr2[i];
        }
    }
}

// Hide elements that are not selected
function w3RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
        }
    }
    element.className = arr1.join(" ");
}

// Add active class to the current control button (highlight it)
/*var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}*/
