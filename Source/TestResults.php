<?php

namespace PhpRepos\TestRunner\TestResults;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use PhpRepos\TestRunner\Document;

function insert(Document $obj): Document
{
    $obj = $obj->init();

    return save($obj);
}

function save(Document $obj): Document
{
    $data = json_encode([
        'collection' => get_class($obj),
        'id' => $obj->id,
        'created_at' => $obj->created_at->format(DateTimeInterface::RFC3339_EXTENDED),
        'updated_at' => $obj->updated_at->format(DateTimeInterface::RFC3339_EXTENDED),
        'version' => $obj->version,
        'path' => $obj->path,
        'filter' => $obj->filter,
        'cases' => $obj->cases,
    ], JSON_PRETTY_PRINT);

    $file = $obj::$storage . $obj->id . '.json';
    $result = file_put_contents($file, $data);

    if ($result === false) {
        throw new Exception('Failed to write JSON data to file: ' . $file);
    }

    return $obj;
}

function find(string $id): Document
{
    $data = json_decode(file_get_contents(Document::$storage . $id . '.json'), true);

    $collection = $data['collection'];
    $id = $data['id'];
    $created_at = new DateTimeImmutable($data['created_at']);
    $updated_at = new DateTimeImmutable($data['updated_at']);
    $version = (int) $data['version'];
    unset($data['collection']);
    unset($data['id']);
    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['version']);
    
    return (new $collection(...$data))->checkout($id, $created_at, $updated_at, $version);
}
