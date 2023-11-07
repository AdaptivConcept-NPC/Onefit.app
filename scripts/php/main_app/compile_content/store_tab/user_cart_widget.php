<?php

$listItemNumber = 0;
$cartItemsVList = "";
$productName = "Aiwa Smart Band ASB-40";
$productImageURL = "../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png";
$productPriceLabel = ""; // format: R 0.00
$productPrice = 259.95;
$productRef = "20220201-879ds6fsdf_id";
$productQty = 1;

// test: compile product price text/label content
function productPrice($currency, $productPrice)
{
    $priceText = "";
    switch ($currency) {
        case null:
            # if blank
            $priceText = "Error: currency not defined";
            break;

        case 'ZAR':
            # if South African Rand
            $priceText = "R $productPrice";
            break;

        default:
            # if unknown currency
            $priceText = "Error: unknown currency [ $currency ]";
            break;
    }

    return $priceText;
};


for ($i = 1; $i <= 5; $i++) {
    # code...
    $listItemNumber += 1;
    $list_item_id = "main-cart-items-list-item-$listItemNumber";
    // reset product price label text
    $productPriceLabel = "R 0.00";
    // test: set product price and currency
    $productPrice = 259.95;
    $currency = "ZAR";
    // call productPrice()
    $productPriceLabel = productPrice($currency, $productPrice);

    $cacheItem = <<<_END
    <li id="$list_item_id" class="list-group-item border-light down-top-grad-tahiti text-dark fs-5 d-flex border-0 border -bottom" style="border-radius: 15px;border-color: var(--mineshaft) !important;">
        <!-- ./ product / item card -->
        <div class="w-100 align-items-center justify-content-between">
            <div class="row gap-2 align-items-start justify-content-start">
                <div class="col-md d-flex gap-1 justify-content-center p-4 top-down-grad-tahitiz rounded-4 no-scroller" style="overflow-x:auto;">
                    <div class="row w-100">
                        <div class="col-md d-grid gap-2 text-start p-0 align-items-center">
                            <div class="poppins-font text-truncate">
                                <span class="badge text-bg-light fs-4">$listItemNumber.</span>
                                <span id="main-cart-items-list-item-name" class="align-middle fs-4 fs-bold text-white"> $productName</span>
                            </div>
                            <div class="poppins-font text-center">
                                <span class="material-icons material-icons-round text-white d-nonez" style="font-size: 22px !important;">toll</span>
                                <span class="fs-1" id="main-cart-items-list-item-price" style="color:var(--white);">$productPriceLabel</span>
                            </div>
                            <div class="text-xsm-center text-sm-center text-md-center text-lg-end"><span class="barcode-font text-truncate" id="cart-producte-ref" style="color: var(--mineshaft);font-size:12px!important;">$productRef</span></div>
                        </div>
                        <div class="col-md-4">
                            <img src="$productImageURL" alt="$productName - $productRef" style="filter: invert(0);max-width:200px;" class="img-fluid shadow-lg rounded-3">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-0 d-flex gap-2 align-items-start justify-content-center">
                    <div class="border-0 border-startz border-endz down-top-grad-tahiti shadow-lg px-2" style="border-radius:25px;">
                        <div class="d-grid justify-content-center my-4">
                            <!-- quantity -->
                            <div class="input-group m-0 d-grid gap-0 justify-content-center">
                                <p class="input-group-text text-center m-0" id="cart-item-quantity-cartitemid" style="font-size: 10px;color:var(--tahitigold)!important;/* background-color:#343434; */border-radius: 14px 14px 0 0;border: 0;">
                                    <span class="material-icons align-middle" style="font-size:20px!important;">
                                    production_quantity_limits
                                    </span> Quantity.
                                </p>
                                <input type="number" class="form-control text-center w-100" value="$productQty" min="0" step="1" oninput="validity.valid||(value='');" placeholder="qty." aria-label="quantity" aria-describedby="cart-item-quantity-cartitemid" style="border: 0;border-radius: 0 0 15px 15px !important;background-color: #343434;color: #fff;min-width: 50px;">
                            </div>
                            <!-- ./ quantity -->
                            <!-- product description -->
                            <div id="prod-highlighted-features" class="d-flex gap-2 mt-4">
                                <span class="material-icons align-middle" style="font-size: 20px!important;">info</span>
                                <span class="align-middle text-wrap" style="font-size: 10px;">Highlighted features.</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-2">
                        <div class="d-flex justify-content-center">
                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-4 text-center shadow-lg -sm bg-transparent" onclick="deleteCartItem('product_id','product_ref','$list_item_id')" style="border-color: var(--red);color: var(--white) !important;">
                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                    highlight_off
                                </span>
                                <span class="d-none d-lg-block text-truncate" style="font-size: 10px;">Remove!</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./ product / item card -->
    </li>
    _END;

    $cartItemsVList .= $cacheItem;
}

$cart_widget_html_template = <<<_END
<!-- Cart Container  -->
<div class="container py-4 d-nonez">
    <div class="text-center">
        <button class="navbar-toggler shadowz onefit-buttons-style-dark rounded-5z p-0 hide-side-panels shadow-lg collapsed border-5 border-bottom" style="overflow:hidden;" type="button" data-bs-toggle="collapse" data-bs-target="#cart-panel" aria-controls="cart-panel" aria-expanded="false" id="main-cart-toggle-btn">
            <div class="row px-4z py-2 m-0 align-items-center rounded-3 top-down-grad-tahiti">
                <div class="col-sm fw-bold comfortaa-font border-startz border-endz border-light p-4 fs-4 d-grid gap-2 text-center text-white" style="min-width:100px;">
                    <span class="material-icons material-icons-round align-middle" style="font-size: 50px !important;">
                        card_membership
                    </span>
                    <span class="align-middle text-truncate" style="font-size: 15px;color: var(--white);">0 Coupons.</span>
                </div>
                <div class="col-sm border-0 border-startz border-endz border-lightz rounded-3 p-4 text-white" style="border-color: var(--white) !important;">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                            shopping_cart </span>
                        <span class="fw-bold comfortaa-font" style="color: var(--white);font-size: 20px;">0</span>
                        <span class="d-nonez d-lg-blockz" id="" style="font-size: 15px;">Items.</span>
                    </div>
                </div>
                <div class="col-sm fw-bold comfortaa-font border-startz border-endz border-light p-4 fs-4 d-grid gap-2 text-center text-white" style="min-width:100px;">
                    <span class="material-icons material-icons-round align-middle" style="font-size: 50px !important;">
                        toll
                    </span>
                    <span class="align-middle text-truncate" style="font-size: 20px;color: var(--white);">R 0.00</span>
                    <span class="align-middle d-none" style="font-size: 10px;color: var(--white);">ZAR</span>
                </div>
            </div>
        </button>
    </div>
    <!-- ./ -->
    <div class="showz down-top-grad-dark w3-animate-top comfortaa-font text-white collapse" style="border-radius: 25px; overflow: hidden;" id="cart-panel">
        <div class="p-4 shadow" id="">
            <div class="text-center d-flex justify-content-between align-items-center">
                <button class="navbar-toggler shadow onefit-buttons-style-light p-4 mb-4 w3-animate-right d-grid gap-1" type="button" onclick="openLink(event, 'TabStore');openLink(event, 'TabStore');document.getElementById('main-cart-toggle-btn').click()">
                    <span class="material-icons material-icons-round align-middle">
                        storefront
                    </span>
                    <span class="align-middle"><span class="d-none d-lg-block">Visit the </span><span style="color: #ffa500 !important;">.Store</span></span>
                </button>

                <div class="w3-animate-top text-center">
                    <!-- <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="max-height: 50px;" alt="logo"> -->
                    <div class="d-grid text-center">
                        <p class="m-0 fs-5 comfortaa-font text-white">Shopping</p>
                        <p class="m-0 fs-1 comfortaa-font text-white">Cart.</p>
                    </div>

                </div>

                <button class="navbar-toggler shadow onefit-buttons-style-light p-4 mb-4 w3-animate-left d-grid gap-1" type="button">
                    <span class="material-icons material-icons-round align-middle">
                        point_of_sale
                    </span>
                    <span class="align-middle">
                        <span class="d-none d-lg-block">Proceed to </span><span class="d-none d-lg-block" style="color: #ffa500 !important;">Checkout.</span>
                    </span><span class="d-lg-none" style="color: #ffa500 !important;">Pay.</span>
                </button>
            </div>
            <!-- ./ -->
            <div class="row">
                <div class="col-xlg-6 py-4 d-grid gap-4">
                    <!-- Cart items vertical list -->
                    <div class="container-fluid p-2 pt-4 top-down-grad-white border-3z border-topz" style="border-radius: 25px;border-color: var(--tahitigold) !important;">
                        <h1 class="text-dark w3-animate-left mb-4">Items ordered.</h1>
                        <!-- Cart items vertical list -->
                        <ul id="main-cart-items-list" class="list-group list-group-flush list-group-numberedz shadow py-4 px-2 w3-animate-left light-scroller top-down-grad-tahiti" style="/* background-color: var(--tahitigold); */overflow-y: auto;border-radius: 25px !important;max-height: 80vh !important;">
                            $cartItemsVList
                        </ul>
                        <!-- ./ Cart items vertical list -->
                    </div>
                    <!-- ./ Cart items vertical list -->
                    <!-- cart / invoice totals -->
                    <div class="container-fluid p-2 pt-4 down-top-grad-tahiti border-3z border-topz" style="border-radius: 25px;border-color: var(--tahitigold) !important;">
                        <!-- invoice number barcode display -->
                        <div id="cart-invoice-ref">
                            <p class="text-center w3-animate-left comfortaa-font d-grid" style="min-height: 30px;">
                                <span class="material-icons material-icons-round align-middle" style="font-size:40px !important;">
                                    receipt_long
                                </span>
                                <span>Invoice Reference.</span>
                                <span> <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;">20220201-879ds6fsdf_id</span> </span> 
                            </p>
                        </div>
                        <!-- ./ invoice number barcode display -->
                        <h1 class="text-white w3-animate-left mb-4">Cart Totals.</h1>
                        <div class="row p-4 pb-0 align-items-center down-top-grad-tahitiz" style="border-radius: 0 0 25px 25px;">
                            <div class="col-md w3-animate-left">
                                <h1>R<span id="shop-cart-total-amt">0.00</span> <span class="align-top" style="font-size: 12px;color: var(--white);">ZAR</span></h1>
                            </div>
                            <div class="col-md -4 border-1 border-start border-end">
                                <h1><span id="shop-cart-total-items">4</span> <span class="align-top" style="font-size: 12px;color: var(--white);">Items</span></h1>
                            </div>
                            <div class="col-md d-flex justify-content-center w3-animate-right">
                                <button id="clear-all-cart-item-btn" class="onefit-buttons-style-danger bg-transparent p-3 text-center" style="border-color: var(--red);">
                                    <div class="d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important">
                                            delete
                                        </span>
                                        <span class="align-middle" style="font-size:10px;">
                                            Empty Cart!
                                        </span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- ./ cart / invoice totals -->
                </div>
                <!-- hidden: horizontal list -->
                <div class="col-xlg-6 py-4 d-none">
                    <p class="text-center w3-animate-right comfortaa-font" style="min-height: 30px;">
                        <span class="material-icons material-icons-round align-middle">
                            shopping_cart
                        </span>
                        Cart Items (<span id="mini-cart-item-count" style="color: #ffa500;">4</span>)
                    </p>
                    <hr class="text-white">
                    <div class="horizontal-scroll p-5 w3-animate-right collapse">
                        <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative down-top-grad-white" style="border-color: #ffa500 !important;">
                            <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                1
                            </div>
                            <div class="d-grid gap-2 justify-content-center">
                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                <div class="text-center">
                                    <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh; filter: invert(0);" alt="placeholder">
                                </div>
                                <!-- ./ -->
                                <p class="fw-bold text-truncate text-center text-dark py-4 poppins-font">
                                    <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                    <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                </p>
                                <div class="d-grid">
                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                            highlight_off
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- ./ -->
                        </div>
                        <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative down-top-grad-white" style="border-color: #ffa500 !important;">
                            <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                2
                            </div>
                            <div class="d-grid gap-2 justify-content-center">
                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                <div class="text-center">
                                    <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh; filter: invert(0);" alt="placeholder">
                                </div>
                                <!-- ./ -->
                                <p class="fw-bold text-truncate text-center text-dark py-4 poppins-font">
                                    <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                    <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                </p>
                                <div class="d-grid">
                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                            highlight_off
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- ./ -->
                        </div>
                        <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative down-top-grad-white" style="border-color: #ffa500 !important;">
                            <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                3
                            </div>
                            <div class="d-grid gap-2 justify-content-center">
                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                <div class="text-center">
                                    <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh; filter: invert(0);" alt="placeholder">
                                </div>

                                <p class="fw-bold text-truncate text-center text-dark py-4 poppins-font">
                                    <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                    <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                </p>
                                <div class="d-grid">
                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                            highlight_off
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- ./ -->
                        </div>
                        <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative down-top-grad-white" style="border-color: #ffa500 !important;">
                            <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                4
                            </div>
                            <div class="d-grid gap-2 justify-content-center">
                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                <div class="text-center">
                                    <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh; filter: invert(0);" alt="placeholder">
                                </div>
                                <!-- ./ -->
                                <p class="fw-bold text-truncate text-center text-dark py-4 poppins-font">
                                    <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                    <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                </p>
                                <div class="d-grid">
                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                            highlight_off
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- ./ -->
                        </div>
                    </div>
                </div>
                <!-- hidden: horizontal list -->
            </div>
        </div>
    </div>
</div>
<!-- ,/ Cart Container  -->
_END;

echo $cart_widget_html_template;
