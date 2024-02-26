import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom/client";

function POS() {
    const [carts, setCarts] = useState([]);
    const [products, setPorudcts] = useState([]);

    const getAllProducts = async () => {
        try {
            const response = await axios.get("/get-product");

            setPorudcts(response.data.products);
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    };

    const addToCart = (product) => {
        const existingProduct = carts.find(
            (cartItem) => cartItem.id === product.id
        );

        if (existingProduct) {
            setCarts((prevCarts) =>
                prevCarts.map((cartItem) =>
                    cartItem.id === product.id
                        ? {
                              ...cartItem,
                              quantity: cartItem.quantity + 1,
                              price: cartItem.price + product.price,
                          }
                        : cartItem
                )
            );
        } else {
            setCarts((prevCarts) => [
                ...prevCarts,
                {
                    ...product,
                    quantity: 1,
                    totalPrice: product.price,
                },
            ]);
        }
    };

    const totalPrice = () => {
        return carts.reduce((total, cartItem) => total + cartItem.price, 0);
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

    useEffect(() => {
        getAllProducts();
    }, []);

    console.log(carts);

    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col-4-lg col-md-4">
                    <form onSubmit={""}>
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
                                        <td>{cart.quantity}</td>
                                        <td>{formatCurrency(cart.price)}</td>
                                    </tr>
                                ))}
                                <tr>
                                    <td>Total</td>
                                    <td></td>

                                    <td>{formatCurrency(totalPrice())}</td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" className="btn btn-danger">
                            Batal
                        </button>
                        <button type="button" className="btn btn-success">
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
                                style={{ width: "12rem", borderRadius: 15 }}
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
                                    <a
                                        className="btn btn-primary"
                                        onClick={() => addToCart(product)}
                                    >
                                        Tambah
                                    </a>
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