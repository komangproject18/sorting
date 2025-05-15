<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SortingController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function sort(Request $request)
    {
        $this->validate($request, [
            'numbers' => 'required|string',
            'algorithm' => 'required|in:bubble,selection',
        ]);

        $numbers = explode(',', $request->input('numbers'));
        $numbers = array_map('trim', $numbers);
        $numbers = array_filter($numbers, function ($value) {
            return is_numeric($value);
        });
        $numbers = array_map('intval', $numbers);

        $algorithm = $request->input('algorithm');

        $originalArray = $numbers;

        if ($algorithm == 'bubble') {
            $sortedArray = $this->bubbleSort($numbers);
            $steps = $this->getBubbleSortSteps($originalArray);
        } else {
            $sortedArray = $this->selectionSort($numbers);
            $steps = $this->getSelectionSortSteps($originalArray);
        }

        return view('result', compact('originalArray', 'sortedArray', 'algorithm', 'steps'));
    }

    private function bubbleSort($arr)
    {
        $n = count($arr);
        $temp = $arr;

        for ($i = 0; $i < $n; $i++) {
            $swapped = false;

            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($temp[$j] > $temp[$j + 1]) {
                    // Swap
                    $t = $temp[$j];
                    $temp[$j] = $temp[$j + 1];
                    $temp[$j + 1] = $t;
                    $swapped = true;
                }
            }

            if ($swapped == false) {
                break;
            }
        }

        return $temp;
    }

    private function selectionSort($arr)
    {
        $n = count($arr);
        $temp = $arr;

        for ($i = 0; $i < $n - 1; $i++) {
            $min_idx = $i;

            for ($j = $i + 1; $j < $n; $j++) {
                if ($temp[$j] < $temp[$min_idx]) {
                    $min_idx = $j;
                }
            }

            if ($min_idx != $i) {
                // Swap
                $t = $temp[$i];
                $temp[$i] = $temp[$min_idx];
                $temp[$min_idx] = $t;
            }
        }

        return $temp;
    }

    private function getBubbleSortSteps($arr)
    {
        $steps = [];
        $n = count($arr);
        $temp = $arr;
        $sortedIndices = [];

        // Initial state
        $steps[] = [
            'array' => $temp,
            'comparing' => [],
            'sorted' => []
        ];

        for ($i = 0; $i < $n; $i++) {
            $swapped = false;

            for ($j = 0; $j < $n - $i - 1; $j++) {
                // Comparing step
                $steps[] = [
                    'array' => $temp,
                    'comparing' => [$j, $j + 1],
                    'sorted' => $sortedIndices
                ];

                if ($temp[$j] > $temp[$j + 1]) {
                    // Swap
                    $t = $temp[$j];
                    $temp[$j] = $temp[$j + 1];
                    $temp[$j + 1] = $t;
                    $swapped = true;

                    // After swap step
                    $steps[] = [
                        'array' => $temp,
                        'comparing' => [$j, $j + 1],
                        'sorted' => $sortedIndices
                    ];
                }
            }

            // Mark element as sorted
            $sortedIndices[] = $n - $i - 1;

            // Add step with newly sorted element
            $steps[] = [
                'array' => $temp,
                'comparing' => [],
                'sorted' => $sortedIndices
            ];

            if (!$swapped) {
                break;
            }
        }

        // Final state (all sorted)
        $allSortedIndices = range(0, $n - 1);
        $steps[] = [
            'array' => $temp,
            'comparing' => [],
            'sorted' => $allSortedIndices
        ];

        return $steps;
    }

    private function getSelectionSortSteps($arr)
    {
        $steps = [];
        $n = count($arr);
        $temp = $arr;
        $sortedIndices = [];

        // Initial state
        $steps[] = [
            'array' => $temp,
            'comparing' => [],
            'sorted' => []
        ];

        for ($i = 0; $i < $n - 1; $i++) {
            $min_idx = $i;

            // Add step to show current position
            $steps[] = [
                'array' => $temp,
                'comparing' => [$i, $min_idx],
                'sorted' => $sortedIndices
            ];

            for ($j = $i + 1; $j < $n; $j++) {
                // Add step to show comparison
                $steps[] = [
                    'array' => $temp,
                    'comparing' => [$min_idx, $j],
                    'sorted' => $sortedIndices
                ];

                if ($temp[$j] < $temp[$min_idx]) {
                    $min_idx = $j;

                    // Add step to show new minimum
                    $steps[] = [
                        'array' => $temp,
                        'comparing' => [$i, $min_idx],
                        'sorted' => $sortedIndices
                    ];
                }
            }

            // Swap the found minimum element with the first element
            if ($min_idx != $i) {
                $t = $temp[$i];
                $temp[$i] = $temp[$min_idx];
                $temp[$min_idx] = $t;

                // Add step after swap
                $steps[] = [
                    'array' => $temp,
                    'comparing' => [$i, $min_idx],
                    'sorted' => $sortedIndices
                ];
            }

            // Mark element as sorted
            $sortedIndices[] = $i;

            // Add step to show sorted element
            $steps[] = [
                'array' => $temp,
                'comparing' => [],
                'sorted' => $sortedIndices
            ];
        }

        // Mark the last element as sorted
        $sortedIndices[] = $n - 1;

        // Final state (all sorted)
        $steps[] = [
            'array' => $temp,
            'comparing' => [],
            'sorted' => $sortedIndices
        ];

        return $steps;
    }
}
