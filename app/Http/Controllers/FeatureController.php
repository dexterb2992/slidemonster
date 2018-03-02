<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;
use App\SubscriptionPlan;

class FeatureController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return [
            'content' => ''
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feature = new Feature;
        $feature->content = $request->content;
        $feature->plan_id = $request->plan_id;

        if ($feature->save()) {
            return [
                'success' => 1,
                'message' => 'A new feature has been added.',
                'id' => $feature->id
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to add a new subscription feature."
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return $feature;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return $feature;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        $feature->content = $request->content;
        if ($feature->save()) {
            return [
                'success' => 1,
                'message' => 'Your changes have been saved.'
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to update a subscription feature."
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        if ($feature->delete()) {
            return [
                'success' => 1,
                'message' => 'Successfully deleted.'
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to delete a subscription feature."
        ];
    }
}
