<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BoardController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function findAllBoards(Request $request)
    {
        return $this->success(Board::where('owner_id', request()->user()->id)->get());
    }

    /**
     * Display a listing of the resource.
     */
    public function findBoard(Request $request, Board $board)
    {
        if ($board->owner_id !== $request->user()->id) {
            throw new NotFoundHttpException();
        }

        $responseData = [
            "board" => $board->setHidden(['owner_id', 'owner']),
            "owner" => $board->owner->name,
        ];

        return $this->success($responseData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createBoard(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
        ]);

        $board = Board::create([
            'name' => $fields['name'],
            'description' => $fields['description'] ?? null,
            'owner_id' => $request->user()->id,
        ]);

        return $this->success("CREATED", 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBoard(Request $request, Board $board)
    {
        $fields = $request->validate([
            'name' => 'string',
            'description' => 'string',
        ]);

        if ($board->owner_id !== $request->user()->id) {
            throw new NotFoundHttpException();
        }

        $board->update($fields);
        $responseData = [
            "board" => $board->setHidden(['owner_id', 'owner']),
            "owner" => $board->owner->name,
        ];

        return $this->success($responseData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteBoard(Board $board)
    {
        if ($board->owner_id !== request()->user()->id) {
            throw new NotFoundHttpException();
        }

        $board->delete();
        return $this->success("DELETED", 204);
    }
}
