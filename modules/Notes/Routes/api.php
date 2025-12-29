<?php

use Illuminate\Http\Request;
use App\Models\Note;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->get('/notes/{user_id}', function (Request $request) {
    return Note::where('user_id', (string)$request->user_id)->get();
});

Route::middleware('api')->get('/note/{note_id}', function (Request $request) {
    return Note::find($request->note_id);
});

Route::middleware('api')->post('/notes', function (Request $request) {
    $note = new Note;
    $note->user_id = $request->input('user_id');
    $note->title = $request->input('title');
    $note->body = $request->input('body');
    $note->save();

    return ['result' => 'success', 'note' => $note->toArray()];
});

Route::middleware('api')->put('/notes/{note_id}', function (Request $request) {
    $note = Note::find($request->note_id);

    $note->user_id = $request->input('user_id');
    $note->title = $request->input('title');
    $note->body = $request->input('body');
    $note->save();

    return ['result' => 'success', 'note' => $note->toArray()];
});

Route::middleware('api')->delete('/notes/{note_id}', function (Request $request) {
    $note = Note::find($request->note_id);

    $note->delete();

    return ['result' => 'success'];
});