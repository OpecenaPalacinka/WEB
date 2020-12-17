
if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded',ready);
} else {
    ready();
}

function ready() {
    var removeCartItemButtons = document.getElementsByClassName('btn-danger');
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var removeButton = removeCartItemButtons[i];
        removeButton.addEventListener('click', removeCartItem);
    }

    var quantityInputs = document.getElementsByClassName('item-quantity');
    for (var j = 0; j < quantityInputs.length; j++){
        var input = quantityInputs[j];
        input.addEventListener('change', quantityChange);
    }

    var addToCartL = document.getElementsByClassName('shop-add-button-l');
    for (var k = 0; k < addToCartL.length; k++){
        var buttonL = addToCartL[k];
        buttonL.addEventListener('click',addtoCartClickedL);
    }

    var addToCartP = document.getElementsByClassName('shop-add-button-p');
    for (var l = 0; l < addToCartP.length; l++){
        var buttonP = addToCartP[l];
        buttonP.addEventListener('click',addtoCartClickedP);
    }

    $('.btn-lg').click(function (){
        var lod1 = $("[name='lod1']").length;
        if (!(lod1 === 0)){
            lod1 = $("[name='lod1']").val();
        }
        var lod2 = $("[name='lod2']").length;
        if (!(lod2 === 0)){
            lod2 = $("[name='lod2']").val();
        }
        var lod3 = $("[name='lod3']").length;
        if (!(lod3 === 0)){
            lod3 = $("[name='lod3']").val();
        }
        var lod4 = $("[name='lod4']").length;
        if (!(lod4 === 0)){
            lod4 = $("[name='lod4']").val();
        }
        var lod5 = $("[name='lod5']").length;
        if (!(lod5 === 0)){
            lod5 = $("[name='lod5']").val();
        }
        var pumpa = $("[name='pumpa']").length;
        if (!(pumpa === 0)){
            pumpa = $("[name='pumpa']").val();
        }
        var padlo = $("[name='padlo']").length;
        if (!(padlo === 0)){
            padlo = $("[name='padlo']").val();
        }
        var vesta_dosp = $("[name='vesta-dosp']").length;
        if (!(vesta_dosp === 0)){
            vesta_dosp = $("[name='vesta-dosp']").val();
        }
        var vesta_dite = $("[name='vesta-dite']").length;
        if (!(vesta_dite === 0)){
            vesta_dite = $("[name='vesta-dite']").val();
        }
        var barel = $("[name='barel']").length;
        if (!(barel === 0)){
            barel = $("[name='barel']").val();
        }
        $.ajax({
            type: 'POST',
            url: '../controller/objednavkaController.class.php',
            data: { lod1: lod1, lod2: lod2, lod3: lod3, lod4: lod4, lod5: lod5, pumpa: pumpa, padlo: padlo,vesta_dosp: vesta_dosp, vesta_dite:vesta_dite,barel:barel},
            success: function (response){
                console.log(response);
            }
        })
        //register();
    })
}

function register(){
   // alert('Thank you!');
    var cartItems = document.getElementsByClassName('list-group')[0];
    while (cartItems.hasChildNodes()){
        cartItems.removeChild(cartItems.firstChild);
    }
    updateCartTotalPrice();
}

function removeCartItem(event) {
    var buttonClicked = event.target;
    buttonClicked.parentElement.remove();
    updateCartTotalPrice();
}

function quantityChange(event){
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0){
        input.value = 1;
    }
    updateCartTotalPrice();
}

function addtoCartClickedL(event) {
    var button = event.target;
    var shopItem = button.parentElement;
    var title = shopItem.getElementsByClassName('cart-item-name-l')[0].innerText;
    var price = shopItem.getElementsByClassName('cart-item-price-l')[0].innerText;
    addItemToCartL(title,price);
    updateCartTotalPrice();
}

function addtoCartClickedP(event) {
    var button = event.target;
    var shopItem = button.parentElement;
    var title = shopItem.getElementsByClassName('cart-item-name-p')[0].innerText;
    var price = shopItem.getElementsByClassName('cart-item-price-p')[0].innerText;
    addItemToCartL(title,price)
    updateCartTotalPrice();
}

function addItemToCartL(title,price){
    var cartRow = document.createElement('div');
    var cartItems = document.getElementsByClassName('list-group')[0];
    var cartItemNames = cartItems.getElementsByClassName('my-0');
    for (var i = 0; i <cartItemNames.length; i++){
        if (cartItemNames[i].innerText === title){
            alert('Už máte ve vozíku');
            return;
        }
    }
    var id;
    switch (title){
        case "Samba 2-m":
            id = "lod1";
            break;
        case "Samba 3-m":
            id = "lod2";
            break;
        case "Colorado 4-m":
            id = "lod3";
            break;
        case "Colorado 6-m":
            id = "lod4";
            break;
        case "Kajak":
            id = "lod5";
            break;
        case "Pumpa k raftu":
            id = "pumpa";
            break;
        case "Pádlo":
            id = "padlo";
            break;
        case "Vesta - dospělý":
            id = "vesta-dosp";
            break;
        case "Vesta - dítě":
            id = "vesta-dite";
            break;
        case "Barel":
            id = "barel";
            break;
    }
    var cartRowContents = `<li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">${title}</h6>
                        <small class="price-cart text-muted">${price}</small>
                    </div>
                    <input type="number" name="${id}" id="${id}" class="item-quantity form-control col-md-3" min="1" value="1">
                    <button class="btn btn-danger" type="button">Odstraň</button>
                </li>`;
    cartRow.innerHTML = cartRowContents;
    cartItems.append(cartRow);
    cartRow.getElementsByClassName('btn-danger')[0].addEventListener('click',removeCartItem);
    cartRow.getElementsByClassName('item-quantity')[0].addEventListener('change', quantityChange);

}


function updateCartTotalPrice() {
    var cartItem = document.getElementsByClassName('list-group')[0];
    var cartRows = cartItem.getElementsByClassName('list-group-item');
    var totalPrice = 0;
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i];
        var priceElement = cartRow.getElementsByClassName('price-cart')[0];
        var quantityElement = cartRow.getElementsByClassName('item-quantity')[0];
        if (priceElement) {
        var price = parseFloat(priceElement.innerText.replace(' KČ',''));
        var quantity = quantityElement.value;
        totalPrice += (price * quantity);
        }
    }
    var itemsInCart = document.getElementsByClassName('badge-pill')[0];
    itemsInCart.innerText = cartRows.length;
    totalPrice = Math.round(totalPrice * 100) / 100;
    document.getElementsByClassName('cart-total')[0].innerText = totalPrice + " KČ";
}