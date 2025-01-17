<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository
{
    public function get(int $noteId): ?Note
    {
        return (new Note())->find($noteId);
    }

    /**
     * @param array<string, string> $parameters
     *
     * @return Collection<int, Note>
     * */
    public function list(array $parameters, int $page, int $limit): Collection
    {
        $skip = ($page * $limit) - $limit;

        $notes = new Note();
        foreach ($parameters as $name => $value) {
            $notes = $notes->where($name, $value);
        }

        return $notes->skip($skip)->take($limit)->orderBy('id', 'DESC')->get();
    }

    /**
     * @param array<string, mixed> $input
     * */
    public function create(array $input, User $authenticatedUser): Note
    {
        return Note::create([
            'name' => $input['name'],
            'content' => $input['content'],
            'status' => $input['status'] ?? Note::STATUS_PUBLISHED,
            'user_id' => $authenticatedUser->id,
        ]);
    }

    /**
     * @param array<string, mixed> $fieldValuePairs
     * */
    public function update(Note $note, array $fieldValuePairs): Note
    {
        $note->fill($fieldValuePairs)->save();

        return $note->refresh();
    }

    /**
     * @param array<string, mixed> $fieldValuePairs
     * */
    public function updateById(int $noteId, array $fieldValuePairs): int
    {
        return (new Note())->where('id', $noteId)->update($fieldValuePairs);
    }

    public function publish(Note $note): Note
    {
        $note->status = Note::STATUS_PUBLISHED;
        $note->save();

        return $note;
    }

    public function draft(Note $note): Note
    {
        $note->status = Note::STATUS_DRAFT;
        $note->save();

        return $note;
    }

    public function delete(Note $note): bool
    {
        return (bool) $note->delete();
    }

    public function deleteById(int $noteId): bool
    {
        $note = $this->get($noteId);

        return (bool) $note?->delete();
    }
}
