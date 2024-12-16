<?php

namespace App\Http\Controllers;

use App\Http\Requests\Train\StoreTrainRequest;
use App\Http\Requests\Train\UpdateTrainRequest;
use App\Models\Train;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TrainController extends Controller
{
    public const RELATIONS = ['carriages'];

    /* Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Trains/Index', [
            'trains' => Train::query()->with(self::RELATIONS)->paginate(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Trains/Create');
    }

    /* Store a newly created resource in storage.
     */
    public function store(StoreTrainRequest $request): RedirectResponse
    {
        Train::query()->create($request->validated());

        session()?->flash('message', 'Train created successfully!');

        return redirect()->route('trains.index');
    }

    /* Display the specified resource.
     */
    public function show(Train $train): Response
    {
        return Inertia::render('Trains/Show', [
            'train' => $train->load(self::RELATIONS),
        ]);
    }

    public function edit(Train $train): Response
    {
        return Inertia::render('Trains/Edit', [
            'train' => $train->load(self::RELATIONS),
        ]);
    }

    /* Update the specified resource in storage.
     */
    public function update(UpdateTrainRequest $request, Train $train): RedirectResponse
    {
        $train->update($request->validated());

        session()?->flash('message', 'Train updated successfully!');

        return redirect()->route('trains.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Train $train): RedirectResponse
    {
        $train->delete();

        session()?->flash('message', 'Train deleted successfully!');

        return redirect()->route('trains.index');
    }
}
