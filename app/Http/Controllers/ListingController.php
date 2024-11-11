<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Listing;

class ListingController extends Controller
{
    // Show all listings
    public function index()
    {
        $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(6);
        return view('listings.index', ['listings' => $listings]);
    }

    // Show a single listing
    public function show(Listing $listing)
    {
        return view('listings.show', ['listing' => $listing]);
    }

    // Show the form to create a new listing
    public function create()
    {
        return view('listings.create');
    }

    // Store the new listing
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/listings')->with('message', 'Listing created successfully');
    }

    // Show the form to edit a listing
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update the listing
    public function update(Request $request, Listing $listing)
    {

        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully');
    }

    // Delete the listing
    public function destroy(Listing $listing)
    {

        //Make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $listing->delete();
        return redirect('/listings')->with('message', 'Listing deleted successfully');
    }

    // Manage Listings
    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
