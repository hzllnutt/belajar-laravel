<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use PSpell\Config;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        $products = Product::with('category')->orderBy('id')->get();
        return view('order.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // buat validasi
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'payment_method' => 'nullable|string',
            // 'customer_name'
        ]);
        try {
            return DB::transaction(function () use ($request) {
                $subtotal = 0;
                $itemsData = [];
                //hitung total &cek ketersedian product
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['id']);
                    if ($product->qty < $item['qty']){
                        return response()->json([
                            'message'=>"Tidak ada stock"
                        ], 422);
                    }

                    $itemSubtotal = $product->price * $item['qty'];
                    $subtotal += $itemSubtotal;

                    $itemsData[] = [
                        'product' => $product,
                        'qty' => $item['qty'],
                        'price' => $product->price,
                        'subtotal' => $itemSubtotal
                    ];
                }

                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;
                $orderCode = 'ORD' . date('Ymd') . '-' . rand(1000, 9999);

                $paymentMethod = $request->payment_method ?? 'cash';

                $order = \App\Models\Order::create([
                    'order_code' => $orderCode,
                    'order_amount' => $total,
                    'order_change' => 0,
                    'status' => $paymentMethod === 'cash' ? 'success' : 'pending',
                ]);
                // orderdetail
                foreach ($itemsData as $data) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $data['product']->id,
                        'order_qty' => $data['qty'],
                        'order_price' => $data['price'],
                        'order_subtotal' => $data['subtotal']
                    ]);
                    if ($paymentMethod === 'cash') {
                        $data['product']->decrement('qty', $data['qty']);
                    }
                }
                if ($paymentMethod === 'midtrans'){
                    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
                    \Midtrans\Config::$isSanitized = true;
                    \Midtrans\Config::$is3ds = true;

                    $params = [
                        "transaction_details" => [
                            "order_id" => $order->order_code,
                            "gross_amount" => (int) round($total)
                        ],
                        "customer_details"=> [
                            'first_name' => $request->customer_name ?? 'No-Name',
                        ],
                        // 'enabled_payments'=> ['gopay', 'qris'],
                    ];

                    $snapToken = \Midtrans\Snap::getSnapToken($params);

                    return response()->json([
                        'success' => true,
                        'payment_method' => 'midtrans',
                        'snap_token' => $snapToken,
                        'order_id' => $order->id,
                    ]);
                }


                return response()->json([
                    'success' => true,
                    'payment_method' => 'cash',
                    'order_id' => $order->id
                ]);
            });
        } catch (Exception $th) {
            //kalau gagal
            return response()->json([
                'message' => 'Gagal menyimpan transaksi' . $th->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
