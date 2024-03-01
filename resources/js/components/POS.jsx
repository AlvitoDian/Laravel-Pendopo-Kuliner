import { colors } from "laravel-mix/src/Log";
import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom/client";

function POS() {
    const [carts, setCarts] = useState([]);
    const [products, setProducts] = useState([]);
    const [sendCarts, setSendCarts] = useState();
    const [maxQuantity, setMaxQuantity] = useState();

    const getAllProducts = async () => {
        try {
            const response = await axios.get("/get-product");

            setProducts(response.data.products);
            setMaxQuantity(response.data.products);
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    };

    const cancelCart = () => {
        setCarts([]);
        getAllProducts();
    };

    const addToCart = (product) => {
        const existingProduct = carts.find(
            (cartItem) => cartItem.id === product.id
        );

        if (existingProduct && product.quantity > 0) {
            setCarts((prevCarts) =>
                prevCarts.map((cartItem) =>
                    cartItem.id === product.id
                        ? {
                              ...cartItem,
                              quantity: cartItem.quantity + 1,
                              totalPrice: cartItem.totalPrice + product.price,
                              product_id: product.id,
                          }
                        : cartItem
                )
            );

            setProducts((prevProducts) =>
                prevProducts.map((prevProduct) =>
                    prevProduct.id === product.id
                        ? {
                              ...prevProduct,
                              quantity: prevProduct.quantity - 1,
                          }
                        : prevProduct
                )
            );
        } else {
            setCarts((prevCarts) => [
                ...prevCarts,
                {
                    ...product,
                    quantity: 1,
                    price: product.price,
                    product_id: product.id,
                    totalPrice: product.price,
                },
            ]);

            setProducts((prevProducts) =>
                prevProducts.map((prevProduct) =>
                    prevProduct.id === product.id
                        ? {
                              ...prevProduct,
                              quantity: prevProduct.quantity - 1,
                          }
                        : prevProduct
                )
            );
        }
    };

    const totalPrice = () => {
        return carts.reduce(
            (total, cartItem) => total + cartItem.totalPrice,
            0
        );
    };

    /*    const minusProductOnCart = (cart) => {
        setCarts((prevCarts) =>
            prevCarts.map((cartItem) =>
                cartItem.id === cart.id
                    ? {
                          ...cartItem,
                          quantity: cartItem.quantity - 1,
                          totalPrice: cartItem.totalPrice - cart.price,
                      }
                    : cartItem
            )
        );

        setProducts((prevProducts) =>
            prevProducts.map((prevProduct) =>
                prevProduct.id === cart.id
                    ? {
                          ...prevProduct,
                          quantity: prevProduct.quantity + 1,
                      }
                    : prevProduct
            )
        );
    };

    const plusProductOnCart = (cart) => {
        setCarts((prevCarts) =>
            prevCarts.map((cartItem) =>
                cartItem.id === cart.id
                    ? {
                          ...cartItem,
                          quantity: cartItem.quantity + 1,
                          totalPrice: cartItem.totalPrice + cart.price,
                      }
                    : cartItem
            )
        );

        setProducts((prevProducts) =>
            prevProducts.map((prevProduct) =>
                prevProduct.id === cart.id
                    ? {
                          ...prevProduct,
                          quantity: prevProduct.quantity - 1,
                      }
                    : prevProduct
            )
        );
    }; */

    const sendCart = async () => {
        if (carts.length === 0) {
            Swal.fire({
                title: "Gagal!",
                text: "Data Produk yang dikirimkan kosong.",
                icon: "error",
                confirmButtonText: "OK",
            });
            return;
        }
        console.log(carts);
        try {
            const totalCartPrice = totalPrice();
            const dataToSend = { carts, allProductPrice: totalCartPrice };
            console.log(dataToSend);
            const response = await axios.post("/store-product", dataToSend, {
                headers: {
                    "Content-type": "application/json",
                },
            });

            if (response.data === "Success: Product Successfully Stored") {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Data Produk Berhasil Disimpan.",
                    icon: "success",
                    confirmButtonText: "OK",
                    willClose: () => {
                        window.location.reload();
                    },
                });
            } else if (
                response.data === "Error: Insufficient Product Quantity"
            ) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat menyimpan data produk.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
            setCarts([]);
            getAllProducts();
        } catch (error) {
            console.error("Error sending data:", error);

            Swal.fire({
                title: "Gagal!",
                text: "Data Produk Gagal Disimpan. Silakan Coba Lagi Nanti.",
                icon: "error",
                confirmButtonText: "OK",
            });
        }
    };

    const formatCurrency = (amount) => {
        const formattedAmount = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(amount);

        return formattedAmount;
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        sendCart();
    };

    const qtyProduct = (cart) => {
        const productQuantity = maxQuantity.find(
            (quantity) => quantity.id === cart
        );
        const maxQ = productQuantity.quantity;
        return maxQ;
    };

    useEffect(() => {
        getAllProducts();
    }, []);

    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col-4-lg col-md-4">
                    <form onSubmit={handleSubmit}>
                        <table className="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Kuantitas</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                {carts.map((cart, index) => (
                                    <tr key={index}>
                                        <td>{cart.name}</td>
                                        <td>
                                            {/*   {cart.quantity > 0 ? (
                                                <a
                                                    className="btn btn-danger mr-2 btn-sm"
                                                    onClick={() =>
                                                        minusProductOnCart(cart)
                                                    }
                                                >
                                                    <i className="fas fa-fw fa-minus"></i>
                                                </a>
                                            ) : (
                                                <></>
                                            )} */}
                                            {/* {cart.quantity} */}
                                            <input
                                                type="number"
                                                className="form-control text-center"
                                                value={cart.quantity}
                                                onChange={(e) => {
                                                    const newQuantity =
                                                        parseInt(
                                                            e.target.value,
                                                            10
                                                        );

                                                    if (
                                                        !isNaN(newQuantity) &&
                                                        newQuantity >= 0 &&
                                                        newQuantity <=
                                                            qtyProduct(cart.id)
                                                    ) {
                                                        setCarts((prevCarts) =>
                                                            prevCarts.map(
                                                                (item) =>
                                                                    item.id ===
                                                                    cart.id
                                                                        ? {
                                                                              ...item,
                                                                              quantity:
                                                                                  newQuantity,
                                                                              totalPrice:
                                                                                  newQuantity *
                                                                                  item.price,
                                                                          }
                                                                        : item
                                                            )
                                                        );

                                                        setProducts(
                                                            (prevProducts) =>
                                                                prevProducts.map(
                                                                    (
                                                                        prevProduct
                                                                    ) =>
                                                                        prevProduct.id ===
                                                                        cart.id
                                                                            ? {
                                                                                  ...prevProduct,
                                                                                  quantity:
                                                                                      prevProduct.quantity -
                                                                                      (newQuantity -
                                                                                          cart.quantity),
                                                                              }
                                                                            : prevProduct
                                                                )
                                                        );
                                                    }
                                                }}
                                            />

                                            {/*    {cart.quantity > 0 ? (
                                                <a
                                                    className="btn btn-success btn-sm ml-2"
                                                    onClick={() =>
                                                        plusProductOnCart(cart)
                                                    }
                                                >
                                                    <i className="fas fa-fw fa-plus"></i>
                                                </a>
                                            ) : (
                                                <></>
                                            )} */}
                                        </td>
                                        <td>
                                            {formatCurrency(cart.totalPrice)}
                                        </td>
                                    </tr>
                                ))}
                                <tr>
                                    <td>Total</td>
                                    <td></td>

                                    <td>{formatCurrency(totalPrice())}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a
                            onClick={() => cancelCart()}
                            className="btn btn-danger mr-2"
                        >
                            Batal
                        </a>
                        <button type="submit" className="btn btn-success b">
                            Kirim
                        </button>
                    </form>
                </div>
                <div className="col-8-lg col-md-8">
                    <div className="d-flex flex-row flex-wrap mb-4">
                        {products.map((product, index) => (
                            <div
                                key={index}
                                className="card mr-3 mt-3 shadow"
                                style={{
                                    width: "12rem",
                                    borderRadius: 15,
                                    borderBottom: "5px solid #D26728",
                                }}
                            >
                                <img
                                    src={`/storage/${product.image}`}
                                    alt={product.category.name}
                                    className=""
                                    style={{
                                        height: 200,
                                        objectFit: "contain",
                                    }}
                                />
                                <div className="card-body">
                                    <h5 className="card-title">
                                        {product.name}
                                    </h5>
                                    <p
                                        className="text-info"
                                        style={{ fontWeight: 400 }}
                                    >
                                        Stok : {product.quantity}
                                    </p>
                                    <h5
                                        className="text-danger"
                                        style={{ fontWeight: 700 }}
                                    >
                                        {formatCurrency(product.price)}
                                    </h5>
                                    <p
                                        className="text-info"
                                        style={{ fontWeight: 400 }}
                                    >
                                        {product.category.name}
                                    </p>
                                    {product.quantity > 0 ? (
                                        <button
                                            className="btn btn-primary"
                                            onClick={() => addToCart(product)}
                                        >
                                            Tambah
                                        </button>
                                    ) : (
                                        <span className="text-danger">
                                            Barang Habis
                                        </span>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default POS;

if (document.getElementById("pos")) {
    const Index = ReactDOM.createRoot(document.getElementById("pos"));

    Index.render(
        <React.StrictMode>
            <POS />
        </React.StrictMode>
    );
}
