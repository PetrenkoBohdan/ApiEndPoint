<?php

declare(strict_types=1);

namespace App\Sevices\FileManager;

use Exception;

use function array_diff;
use function array_filter;
use function array_key_exists;
use function array_key_first;
use function array_push;
use function json_encode;
use function preg_match;
use function scandir;

class FileManager
{
    /**
     * @param array $bag
     *
     * @return array|null
     * @throws Exception
     */
    public function manage(array $bag): ?string
    {
        $fileNames = array_diff(scandir(__DIR__ . '/../../..'), ['.', '..']);

        if ($bag && array_key_exists('filter', $bag)) {
            $filterKey = $bag['filter'];
            switch (array_key_first($filterKey)) {
                case 'symbols':
                    return $this->jsonFormatter($this->filterBySymbols($filterKey['symbols'], $fileNames));
                    break;
                default:
                    throw new Exception('Filter doesn\'t allowed');
            }
        };

        return $this->jsonFormatter($fileNames);
    }

    private function jsonFormatter(array $filesNames): string
    {
        $json = [];

        foreach ($filesNames as $key => $filesName) {
            array_push($json, $this->getData($key, $filesName));
        }

        return json_encode(['data' => $json]);
    }

    private function getData(int $key, string $value): array
    {
        return [
            'type' => 'file',
            'id' => ++$key,
            'attributes' => [
                'fileName' => $value,
            ],
        ];
    }

    private function filterBySymbols(string $filterValue, array $files): array
    {
        return array_filter($files, function ($value) use ($filterValue, $files) {
            return preg_match("/{$filterValue}/", $value);
        });
    }
}