<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace App\Components\MyLibrary;

use App\Album;
use Illuminate\Support\Collection;

class AlbumDao
{
    public function getAlbums()
    {
        $albums = Album::ofCurrentUser()
            ->with('artists')
            ->orderBy('name', 'asc')
            ->get();

        return $albums;
    }

    /**
     * @return Collection
     */
    public function getAlbumsByFirstLetter()
    {
        $alphaLetterOccurrences = $this->getAlphaLetterOccurrences();
        $nonAlphaLetterOccurrences = $this->getNonAlphaLetterOccurrences();
        $this->loadAlbumsForOccurrences($alphaLetterOccurrences);
        $this->loadAlbumsForOccurrences($nonAlphaLetterOccurrences);

        return $alphaLetterOccurrences->prepend($nonAlphaLetterOccurrences);
    }

    /**
     * @return Collection
     */
    private function getAlphaLetterOccurrences()
    {
        $alphaLetterOccurrences = Album::ofCurrentUser()
            ->selectRaw('substr(UPPER(name), 1, 1) as firstLetter, count(id) as count')
            ->groupBy('firstLetter')
            ->orderBy('firstLetter', 'asc')
            ->havingRaw('firstLetter REGEXP "^[A-Z]"')
            ->get()->mapInto(AlbumByLetterOccurrence::class);

        return $alphaLetterOccurrences;
    }

    private function getNonAlphaLetterOccurrences()
    {
        $nonAlphaLetterOccurrences = Album::ofCurrentUser()
            ->selectRaw('substr(UPPER(name), 1, 1) as firstLetter, count(id) as count')
            ->groupBy('firstLetter')
            ->orderBy('firstLetter', 'asc')
            ->havingRaw('firstLetter NOT REGEXP "^[A-Z]"')
            ->get()->mapInto(AlbumByLetterOccurrence::class);

        $nonAlphaLetterOccurrences = $nonAlphaLetterOccurrences->reduce(function (
            AlbumByLetterOccurrence $concatOccurrence = null,
            AlbumByLetterOccurrence $occurrence
        ) {
            $occurrence->loadItems();
            $occurrence->setLetter('#');
            if ($concatOccurrence) {
                $occurrence->setCount($concatOccurrence->getCount() + $occurrence->getCount());
                $occurrence->setItems($concatOccurrence->getItems()->concat($occurrence->getItems()));
            }
            return $occurrence;
        }, null);

        return $nonAlphaLetterOccurrences;
    }

    private function loadAlbumsForOccurrences($occurrences)
    {
        /** @var AlbumByLetterOccurrence $occurrence */
        foreach ($occurrences as $occurrence) {
            $occurrence->loadItems();
        }
    }
}