import React from "react";
import ReactDOM from "react-dom/client";
import Cart from './components/cart';

// Mount React only if the div exists
if (document.getElementById("cart-app")) {
    ReactDOM.createRoot(document.getElementById("cart-app")).render(
        <React.StrictMode>
            <Cart />
        </React.StrictMode>
    );
}
