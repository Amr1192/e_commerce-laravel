<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $products = $query->paginate(9)->withQueryString();

        return view('home', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:64|unique:products,sku',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'status' => 'nullable|in:active,draft,archived',
            'compare_at_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(string $id)
    {
        $product = Product::query()->with('category')->findOrFail($id);

        return view('show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::query()->findOrFail($id);
        $categories = Category::all();

        return view('edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'sku' => ['nullable', 'string', 'max:64', Rule::unique('products', 'sku')->ignore($product->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'status' => 'nullable|in:active,draft,archived',
            'compare_at_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && ! str_starts_with($product->image, 'images/') && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.show', $product->id)->with('success', 'Product updated successfully');
    }

    public function patch(Request $request, string $id)
    {
        return $this->update($request, $id);
    }

    public function put(Request $request, string $id)
    {
        return $this->update($request, $id);
    }

    public function destroy(string $id)
    {
        if (Gate::allows('delete')) {
            $product = Product::query()->findOrFail($id);
            $product->delete();

            return redirect('/');
        }

        return redirect()
            ->back()
            ->with('error', 'You are not authorized to delete posts.');
    }
}
