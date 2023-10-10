<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ListingController extends Controller
{
    public function index()
    {

        return view('listings/index',[
            'listings' =>  Listing::latest()
                         ->filter(request(['tags','search']))
                         ->paginate(6)
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show',['listing' => $listing]);
    }

    public function create()
    {
        
        return view('listings.create');
    }

    public function store(Request $request)
    {   
  

            $formFields = $request->validate([
                'title' => 'required',
                'company' => 'required|unique:listings,company',
                'location' => 'required',
                'website' => 'required',
                'email' => 'required|unique:listings,email',
                'tags' => 'required',
                'description' => 'required'
            ]);
            
            if($request->hasFile('logo'))
            {
                $formFields['logo'] = $request->file('logo')->store('logo','public');
            }
            
            $formFields['user_id'] = auth()->id();

            Listing::create($formFields);

       return redirect('/')->with('message','Listing created successfully');
    }

    public function edit(Listing $listing)
    {
        if($listing->user_id !== auth()->id())
        {
            abort('403','Unauthorized');
        }
        return view('listings.edit', ['listing' => $listing]);
    }


    /**
     * Update Listing Table
     *
     * @param Request $request
     * @param Listing $listing
     * @return void
     */
    public function update(Request $request, Listing $listing)
    {
        if($listing->user_id != auth()->id())
        {
            abort('403','Unauthorized');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')->ignore($listing->id)],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required',Rule::unique('listings','email')->ignore($listing->id)],
            'tags' => 'required',
            'description' => 'required'
        ]);

        $listing->update($formFields);
        return back()->with('message','Successfully updated');
    }

    public function destroy(Listing $listing)
    {
        if($listing->user_id != auth()->id())
        {
            abort('403','Unauthorized');
        }
        $listing->delete();

        return redirect('/')->with('message','Successfully delete '.$listing->title);
    }

    public function manage()
    {   
        $user = User::find(auth()->id());
  
        return view('listings.manage',['listings' => $user->listings()->get()]);
    }
}


