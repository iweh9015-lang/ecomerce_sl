<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    // Inject Service melalui Constructor
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        // Load produk dan gambar untuk ditampilkan
        $cart->load(['items.product.primaryImage']);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);
            $this->cartService->addProduct($product, $request->quantity);

            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        try {
            $this->cartService->updateQuantity($itemId, $request->quantity);

            return back()->with('success', 'Keranjang diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove($itemId)
    {
        try {
            $this->cartService->removeItem($itemId);

            return back()->with('success', 'Item dihapus dari keranjang.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
