<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Movie $movie)
    {
        //
        return view("movie.detailmovie",["movie" => $movie]);
    }

    public function schedule(Movie $movie){
        return view("movie.schedulepage",["movie" => $movie]);
    }

    public function booking_seat(Request $r){
        return view("movie.bookingseat");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMovieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovieRequest  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
