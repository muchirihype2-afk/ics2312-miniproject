<?php

declare(strict_types=1);

namespace App;

class SearchSorter
{
    /**
     * Linear search: scan left-to-right, return the first matching index or -1.
     */
    public function linearSearch(array $items, int|string $target): int
    {
        foreach ($items as $index => $value) {
            if ($value === $target) {
                return $index;
            }
        }
        return -1;
    }

    /**
     * Binary search: works only on an ascending sorted array.
     */
    public function binarySearch(array $items, int|string $target): int
    {
        $low = 0;
        $high = count($items) - 1;

        while ($low <= $high) {
            $mid = intdiv($low + $high, 2);
            $midVal = $items[$mid];

            if ($midVal === $target) {
                return $mid;
            }

            if ($midVal < $target) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        return -1;
    }

    /**
     * Bubble sort (naive, no early exit) – counts every comparison.
     *
     * @return array{sorted: array<int, int|float|string>, iterations: int}
     */
    public function bubbleSort(array $items): array
    {
        $sorted = $items;
        $n = count($sorted);
        $iterations = 0;

        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                $iterations++; // count this comparison
                if ($sorted[$j] > $sorted[$j + 1]) {
                    // swap
                    $temp = $sorted[$j];
                    $sorted[$j] = $sorted[$j + 1];
                    $sorted[$j + 1] = $temp;
                }
            }
        }

        return ['sorted' => $sorted, 'iterations' => $iterations];
    }

    /**
     * Selection sort – counts comparisons against the current minimum.
     *
     * @return array{sorted: array<int, int|float|string>, iterations: int}
     */
    public function selectionSort(array $items): array
    {
        $sorted = $items;
        $n = count($sorted);
        $iterations = 0;

        for ($i = 0; $i < $n - 1; $i++) {
            $minIdx = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                $iterations++; // comparison
                if ($sorted[$j] < $sorted[$minIdx]) {
                    $minIdx = $j;
                }
            }
            if ($minIdx !== $i) {
                $temp = $sorted[$i];
                $sorted[$i] = $sorted[$minIdx];
                $sorted[$minIdx] = $temp;
            }
        }

        return ['sorted' => $sorted, 'iterations' => $iterations];
    }

    /**
     * Insertion sort – counts each comparison while searching for the insert point.
     *
     * @return array{sorted: array<int, int|float|string>, iterations: int}
     */
    public function insertionSort(array $items): array
    {
        $sorted = $items;
        $n = count($sorted);
        $iterations = 0;

        for ($i = 1; $i < $n; $i++) {
            $key = $sorted[$i];
            $j = $i - 1;

            while ($j >= 0) {
                $iterations++; // the comparison about to happen
                if ($sorted[$j] > $key) {
                    $sorted[$j + 1] = $sorted[$j];
                    $j--;
                } else {
                    break;
                }
            }
            $sorted[$j + 1] = $key;
        }

        return ['sorted' => $sorted, 'iterations' => $iterations];
    }
}
