<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all attributes
        $attributes = Attribute::all();

        // Return the view and pass the attributes
        return view('admin.attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tbl_attribute,name', // Ensure unique attribute name
            'description' => 'required|string', // Attribute description is required
        ]);

        try {
            // Create the new attribute
            $attribute = new Attribute();
            $attribute->name = $validated['name'];
            $attribute->description = $validated['description'];

            // Save the attribute to the database
            $attribute->save();

            // Redirect back with success message
            return redirect()->route('attribute.index')->with('message', 'Attribute added successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return redirect()->back()->with('message', 'An error occurred while adding the attribute.');
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
    public function edit($id)
    {
        // Find the attribute by ID
        $attribute = Attribute::findOrFail($id);

        // Return the edit view and pass the attribute
        return view('admin.attribute.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tbl_attribute,name,' . $id, // Unique except for current record
            'description' => 'required|string',
        ]);

        // Find the attribute by ID
        $attribute = Attribute::findOrFail($id);

        // Update the attribute's fields
        $attribute->name = $validated['name'];
        $attribute->description = $validated['description'];

        // Save the updated attribute
        $attribute->save();

        // Redirect back with a success message
        return redirect()->route('attribute.index')->with('message', 'Attribute updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the attribute by ID
        $attribute = Attribute::findOrFail($id);

        // Delete the attribute
        $attribute->delete();

        // Redirect back with a success message
        return redirect()->route('attribute.index')->with('message', 'Attribute deleted successfully.');
    }
}
