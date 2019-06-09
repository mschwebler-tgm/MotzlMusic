<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace App\Components\MyLibrary;

use App\Artist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ArtistDao
{
    /**
     * @return Collection
     */
    public function getArtistsByFirstLetter()
    {
        $alphaLetterOccurrences = $this->getAlphaLetterOccurrences();
        $nonAlphaLetterOccurrences = $this->getNonAlphaLetterOccurrences();
        $this->loadArtistsForOccurrences($alphaLetterOccurrences);
        $this->loadArtistsForOccurrences($nonAlphaLetterOccurrences);

        return $alphaLetterOccurrences->prepend($nonAlphaLetterOccurrences);
    }

    /**
     * @return Collection
     */
    private function getAlphaLetterOccurrences()
    {
        $alphaLetterOccurrences = Artist::ofCurrentUser()
            ->selectRaw('substr(UPPER(name), 1, 1) as firstLetter, count(id) as count')
            ->groupBy('firstLetter')
            ->orderBy('firstLetter', 'asc')
            ->havingRaw('firstLetter REGEXP "^[A-Z]"')
            ->get()->mapInto(ArtistByLetterOccurrence::class);

        return $alphaLetterOccurrences;
    }

    private function getNonAlphaLetterOccurrences()
    {
        $nonAlphaLetterOccurrences = Artist::ofCurrentUser()
            ->selectRaw('substr(UPPER(name), 1, 1) as firstLetter, count(id) as count')
            ->groupBy('firstLetter')
            ->orderBy('firstLetter', 'asc')
            ->havingRaw('firstLetter NOT REGEXP "^[A-Z]"')
            ->get()->mapInto(ArtistByLetterOccurrence::class);

        $nonAlphaLetterOccurrences = $nonAlphaLetterOccurrences->reduce(function (
            ArtistByLetterOccurrence $concatOccurrence = null,
            ArtistByLetterOccurrence $occurrence
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

    private function loadArtistsForOccurrences($occurrences)
    {
        /** @var ArtistByLetterOccurrence $occurrence */
        foreach ($occurrences as $occurrence) {
            $occurrence->loadItems();
        }
    }
}