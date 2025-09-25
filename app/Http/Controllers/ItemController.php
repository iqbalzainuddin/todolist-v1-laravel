<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Column;
use App\Models\Board;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Traits\ApiResponses;

class ItemController extends Controller
{
    use ApiResponses;

    /**
     * Return a listing of the resource.
     */
    public function findAllItems(Request $request, Board $board, Column $column)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id) {
            throw new NotFoundHttpException();
        }

        return $this->success($column->items);
    }

    /**
     * Return the resource.
     */
    public function findItem(Request $request, Board $board, Column $column, Item $item)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id || $item->column_id !== $column->id) {
            throw new NotFoundHttpException();
        }

        return $this->success($item);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createItem(Request $request, Board $board, Column $column)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item = $column->items()->create($fields);

        return $this->success($item, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateItem(Request $request, Board $board, Column $column, Item $item)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id || $item->column_id !== $column->id) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'column_id' => 'sometimes|required|exists:columns,id',
        ]);

        $item->update($fields);

        return $this->success($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteItem(Request $request, Board $board, Column $column, Item $item)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id || $item->column_id !== $column->id) {
            throw new NotFoundHttpException();
        }

        $item->delete();

        return $this->success(null, 204);
    }
}
