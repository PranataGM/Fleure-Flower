<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::query();
        if ($request->filled('search'))   $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('status'))   $query->where('status', $request->status);
        $products = $query->latest()->paginate(15)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        return view('admin.products.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|in:buket,fresh_flower,amplop',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'status'      => 'required|in:available,sold_out',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = basename($path);
        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product) {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|in:buket,fresh_flower,amplop',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'status'      => 'required|in:available,sold_out',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('products/' . $product->image);
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = basename($path);
        } else {
            unset($validated['image']);
        }
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product) {
        Storage::disk('public')->delete('products/' . $product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
