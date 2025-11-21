<?php

namespace App\Http\Controllers;

use App\Application\Cart\Actions\AddToCartAction;
use App\Application\Cart\Actions\GetUserCartAction;
use App\Application\Cart\Actions\RemoveFromCartAction;
use App\Application\Cart\Actions\UpdateCartQuantityAction;
use App\Application\Cart\DTOs\AddToCartDTO;
use App\Application\Cart\DTOs\GetUserCartDTO;
use App\Application\Cart\DTOs\RemoveFromCartDTO;
use App\Application\Cart\DTOs\UpdateCartQuantityDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private AddToCartAction $addToCartAction,
        private RemoveFromCartAction $removeFromCartAction,
        private UpdateCartQuantityAction $updateCartQuantityAction,
        private GetUserCartAction $getUserCartAction,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request): View|JsonResponse
    {
        $dto = new GetUserCartDTO(userId: $request->user()->id);
        $cartItems = $this->getUserCartAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'cart_items' => $cartItems,
            ]);
        }

        return view('cart.index', [
            'cartItems' => $cartItems,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $dto = new AddToCartDTO(
            userId: $request->user()->id,
            productId: $validated['product_id'],
            quantity: $validated['quantity'],
        );

        $cartItem = $this->addToCartAction->execute($dto);

        return response()->json([
            'message' => 'Item added to cart',
            'cart_item' => $cartItem,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $dto = new UpdateCartQuantityDTO(
            userId: $request->user()->id,
            cartItemId: $id,
            quantity: $validated['quantity'],
        );

        $this->updateCartQuantityAction->execute($dto);

        return response()->json([
            'message' => 'Cart item updated',
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $dto = new RemoveFromCartDTO(
            userId: $request->user()->id,
            cartItemId: $id,
        );

        $this->removeFromCartAction->execute($dto);

        return response()->json([
            'message' => 'Item removed from cart',
        ]);
    }
}

