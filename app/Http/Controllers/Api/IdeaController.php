<?php

namespace App\Http\Controllers\Api;

use App\Models\Idea;
use App\Ideas\QueryAnalyzer;
use App\Http\Requests\IdeaRequest;
use App\Http\Controllers\Controller;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ideas = Idea::all();

        return response($ideas->load(['tags', 'attachments']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Ideas\QueryAnalyzer  $analyzer
     * @return \Illuminate\Http\Response
     */
    public function store(QueryAnalyzer $analyzer)
    {
        dd($analyzer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        return response($idea->load(['tags', 'attachments']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\IdeaRequest  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();

        return response(203);
    }
}
