<?php

namespace App\Http\Controllers;

use App\Application\Checkout\Actions\CalculateCartTotalsAction;
use App\Application\Checkout\Actions\ProcessCheckoutAction;
use App\Application\Checkout\DTOs\CalculateCartTotalsDTO;
use App\Application\Checkout\DTOs\ProcessCheckoutDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CalculateCartTotalsAction $calculateCartTotalsAction,
        private ProcessCheckoutAction $processCheckoutAction,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request): View|JsonResponse
    {
        $dto = new CalculateCartTotalsDTO(
            userId: $request->user()->id,
            shippingCost: $request->input('shipping_cost'),
            discount: $request->input('discount'),
            taxRate: $request->input('tax_rate', 0),
        );

        $totals = $this->calculateCartTotalsAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'totals' => $totals,
            ]);
        }

        return view('checkout.index', [
            'totals' => $totals,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'billing_address_line1' => 'nullable|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:100',
            'payment_method' => 'required|string|in:stripe,paypal,local_gateway,credit_card,bank_transfer',
            'payment_data' => 'nullable|array',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $dto = new ProcessCheckoutDTO(
            userId: $request->user()->id,
            shippingAddressLine1: $validated['shipping_address_line1'],
            shippingAddressLine2: $validated['shipping_address_line2'] ?? '',
            shippingCity: $validated['shipping_city'],
            shippingState: $validated['shipping_state'],
            shippingPostalCode: $validated['shipping_postal_code'],
            shippingCountry: $validated['shipping_country'],
            billingAddressLine1: $validated['billing_address_line1'] ?? null,
            billingAddressLine2: $validated['billing_address_line2'] ?? null,
            billingCity: $validated['billing_city'] ?? null,
            billingState: $validated['billing_state'] ?? null,
            billingPostalCode: $validated['billing_postal_code'] ?? null,
            billingCountry: $validated['billing_country'] ?? null,
            paymentMethod: $validated['payment_method'],
            paymentData: $validated['payment_data'] ?? null,
            shippingCost: $validated['shipping_cost'] ?? null,
            discount: $validated['discount'] ?? null,
            taxRate: $validated['tax_rate'] ?? 0,
        );

        $result = $this->processCheckoutAction->execute($dto);

        return response()->json([
            'message' => 'Checkout completed successfully',
            'order' => $result['order'],
            'payment' => $result['payment'],
        ], 201);
    }
}

