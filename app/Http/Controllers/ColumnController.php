<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Traits\ApiResponses;

class ColumnController extends Controller
{
    use ApiResponses;

    /**
     * Return a listing of the resource.
     */
    public function findAllColumns(Request $request, Board $board)
    {
        if ($board->owner_id !== $request->user()->id) {
            throw new NotFoundHttpException();
        }

        return $this->success($board->columns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createColumn(Request $request, Board $board)
    {
        if ($board->owner_id !== $request->user()->id) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'name' => 'required|string'
        ]);

        $count = $board->columns()->count();

        $column = Column::create([
            'name' => $fields['name'],
            'position' => $count + 1,
            'board_id' => $board->id
        ]);
        
        return $this->success($column, 201);
    }

    /**
     * Display the specified resource.
     */
    public function findColumn(Request $request, Board $board, Column $column)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id) {
            throw new NotFoundHttpException();
        }

        return $this->success($column);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateColumn(Request $request, Board $board, Column $column)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'name' => 'required|string'
        ]);

        $column->update($fields);

        return $this->success($column);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteColumn(Request $request, Board $board, Column $column)
    {
        if ($board->owner_id !== $request->user()->id || $column->board_id !== $board->id) {
            throw new NotFoundHttpException();
        }

        $column->delete();

        return $this->success('Column deleted successfully', 204);
    }
}
