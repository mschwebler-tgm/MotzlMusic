<?php
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace App\Components\MyLibrary;

use Illuminate\Support\Collection;

abstract class AbstractByLetterDao
{
    /** @return string AbstractItemByLetter::class */
    abstract protected function getByLetterOccurrenceClass();

    /** @return Builder */
    abstract protected function baseQuery();

    /**
     * @return Collection
     */
    public function getItemsByFirstLetter()
    {
        $alphaLetterOccurrences = $this->getAlphaLetterOccurrences();
        $nonAlphaLetterOccurrences = $this->getNonAlphaLetterOccurrences();
        $this->loadItemIdsForOccurrences($alphaLetterOccurrences);
        $this->loadItemIdsForOccurrences($nonAlphaLetterOccurrences);

        return $alphaLetterOccurrences->prepend($nonAlphaLetterOccurrences)->filter();
    }

    /**
     * @return Collection
     */
    private function getAlphaLetterOccurrences()
    {
        return $this->baseQuery()
            ->selectRaw('substr(UPPER(name), 1, 1) as firstLetter, count(id) as count')
            ->groupBy('firstLetter')
            ->orderBy('firstLetter', 'asc')
            ->havingRaw('firstLetter REGEXP "^[A-Z]"')
            ->get()
            ->mapInto($this->getByLetterOccurrenceClass());
    }

    private function getNonAlphaLetterOccurrences()
    {
        $nonAlphaLetterOccurrences = $this->baseQuery()
            ->selectRaw('substr(UPPER(name), 1, 1) as firstLetter, count(id) as count')
            ->groupBy('firstLetter')
            ->orderBy('firstLetter', 'asc')
            ->havingRaw('firstLetter NOT REGEXP "^[A-Z]"')
            ->get()
            ->mapInto($this->getByLetterOccurrenceClass());

        $nonAlphaLetterOccurrences = $nonAlphaLetterOccurrences->reduce(function (
            AbstractItemByLetter $concatOccurrence = null,
            AbstractItemByLetter $occurrence
        ) {
            $occurrence->loadIds();
            $occurrence->setLetter('#');
            if ($concatOccurrence) {
                $occurrence->setCount($concatOccurrence->getCount() + $occurrence->getCount());
                $occurrence->setItems($concatOccurrence->getItems()->concat($occurrence->getItems()));
            }
            return $occurrence;
        }, null);

        return $nonAlphaLetterOccurrences;
    }

    private function loadItemIdsForOccurrences($occurrences)
    {
        if (!$occurrences) {
            return;
        }

        /** @var ArtistByLetterOccurrence $occurrence */
        foreach ($occurrences as $occurrence) {
            $occurrence->loadIds();
        }
    }
}
