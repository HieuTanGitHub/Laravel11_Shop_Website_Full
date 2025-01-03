<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\Product;
use File;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'product_id' => 'required', // Validate that product_id exists in the products table
            'name' => 'required|string|max:255|unique:tbl_product_attribute,name', // Validate that name is required, is a string, and has a max length of 255
            'price' => 'required|min:1', // Validate that price is required, a number, and at least 1
            'quantity' => 'required|numeric|min:1', // Validate that quantity is required, a number, and at least 1
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate that image is required, an image, and has correct file types and size
            'description' => 'required|string', // Validate that description is required and is a string
            'attribute_id' => 'required', // Validate that attribute_id exists in the attributes table
        ]);

        // dd($validated);
        try {
            // Handle image upload
            $imagePath = null;
            $path = public_path('uploads/attribute/');

            // Ensure the directory exists
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image'); // Get the uploaded image
                $get_name_image = $image->getClientOriginalName(); // Get the original file name
                $name_image = pathinfo($get_name_image, PATHINFO_FILENAME); // Get the name without the extension
                $new_image =  $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension(); // Create a new name for the image

                // Move the image to the attribute upload path
                $image->move($path, $new_image);

                // Store the new image name in $imagePath
                $imagePath = 'uploads/attribute/' . $new_image;
            }

            // Create a new product attribute
            ProductAttribute::create([
                'product_id' => $validated['product_id'],
                'name' => $validated['name'],
                'price' => $validated['price'],
                'quantity' => $validated['quantity'],
                'image' => $new_image,
                'description' => $validated['description'],
                'attribute_id' => $validated['attribute_id'],
            ]);

            return redirect()->back()->with('message', 'Product attribute added successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('message', 'An error occurred while adding the product attribute.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where('product_id', $id)->first();
        $attribute = Attribute::orderBy('id', 'DESC')->get();
        $product_attribute = ProductAttribute::with('product', 'attribute')->where('product_id', $id)->orderBy('id', 'DESC')->get();

        return view('admin.product_attribute.create', compact('product', 'attribute', 'product_attribute'));
    }
    public function deleteProductAttribute(Request $request, $id_attribute)
    {
        try {
            // Find the product attribute by ID
            $productAttribute = ProductAttribute::find($id_attribute);

            // Check if the attribute exists
            if (!$productAttribute) {
                return redirect()->back()->with('message', 'Product attribute not found.');
            }

            // Delete the product attribute
            $productAttribute->delete();

            return redirect()->back()->with('message', 'Product attribute deleted successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('message', 'An error occurred while deleting the product attribute.');
        }
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
