<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\MetaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JustOrangeController extends Controller
{
    public function index(): \Inertia\Response
    {
        $data['products'] = Product::where('active',true)->orderBy('id','desc')->get();
        return Inertia::render('justorange-default',$data);
    }

    public function confirmOrderIndex(): \Inertia\Response
    {
        $products = Product::where('active', true)->get();
        return Inertia::render('confirm-order', ['products' => $products]);
    }

    public function confirmOrder(Request $request, $id): \Inertia\Response
    {
        $product = Product::findOrFail($id);
        $products = Product::where('active', true)->get();
        return Inertia::render('confirm-order', ['product' => $product, 'products' => $products]);
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_type' => 'required|in:shopee,lynkid,whatsapp,web',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_proof' => 'required|image|mimes:jpg,png,jpeg,webp,heic|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        $payment_proof = null;
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $payment_proof = $path;
        }

        Order::create([
            'invoice' => $invoice,
            'product_id' => $request->product_id,
            'order_type' => $request->order_type,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'price' => $product->price,
            'status' => 'WAITING_CONFIRMATION',
            'payment_proof' => $payment_proof,
        ]);

        return redirect()->route('confirm-order-index')->with('success', 'Konfirmasi berhasil, anda akan kami kabari via whatsapp untuk detail akun member anda');
    }
}
