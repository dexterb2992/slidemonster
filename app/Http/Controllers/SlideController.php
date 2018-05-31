<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;

use App\Slide;
use App\Http\Requests\SlideRequest;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return $user->slides()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Slide::form();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        $inputs = $request->all();

        if (!empty($request->types)) {
            $inputs['types'] = json_encode($request->types);
        }
        $slide = new Slide($inputs);
        $slide->user_id = Auth::user()->id;

        if ($slide->save()) {
            return [
                'success' => 1,
                'message' => 'Slide successfully created.'
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to create a new slide."
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        if (empty($slide->types)) {
            $slide->types = [];
            // $slide->types = '["adcontent", "social"]';
        } else {
            $slide->types = json_decode($slide->types);
        }

        return $slide;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        if (empty($slide->types)) {
            $slide->types = [];
            // $slide->types = '["adcontent", "social"]';
        } else {
            $slide->types = json_decode($slide->types);
        }

        return $slide;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $inputs = $request->all();

        // dd($inputs);

        if (!empty($request->types)) {
            $inputs['types'] = json_encode($request->types);
        }

        if ($slide->update($inputs)) {
            return [
                'success' => 1,
                'message' => 'Slide successfully updated.'
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to create a new slide."
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        if ($slide->delete()) {
            return [
                'success' => 1,
                'message' => "Successfully deleted."
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to delete your slide. Please try again later."
        ];
    }
}
