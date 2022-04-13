<?php

declare (strict_types=1);
namespace Rector\Caching\ValueObject\Storage;

use FilesystemIterator;
use RectorPrefix20211231\Nette\Utils\FileSystem;
use RectorPrefix20211231\Nette\Utils\Random;
use Rector\Caching\Contract\ValueObject\Storage\CacheStorageInterface;
use Rector\Caching\ValueObject\CacheFilePaths;
use Rector\Caching\ValueObject\CacheItem;
use Rector\Core\Exception\Cache\CachingException;
use RectorPrefix20211231\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * Inspired by https://github.com/phpstan/phpstan-src/blob/1e7ceae933f07e5a250b61ed94799e6c2ea8daa2/src/Cache/FileCacheStorage.php
 * @see \Rector\Tests\Caching\ValueObject\Storage\FileCacheStorageTest
 */
final class FileCacheStorage implements \Rector\Caching\Contract\ValueObject\Storage\CacheStorageInterface
{
    /**
     * @var string
     */
    private $directory;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(string $directory, \RectorPrefix20211231\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->directory = $directory;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function load(string $key, string $variableKey)
    {
        return (function (string $key, string $variableKey) {
            $cacheFilePaths = $this->getCacheFilePaths($key);
            $filePath = $cacheFilePaths->getFilePath();
            if (!\is_file($filePath)) {
                return null;
            }
            $cacheItem = (require $filePath);
            if (!$cacheItem instanceof \Rector\Caching\ValueObject\CacheItem) {
                return null;
            }
            if (!$cacheItem->isVariableKeyValid($variableKey)) {
                return null;
            }
            return $cacheItem->getData();
        })($key, $variableKey);
    }
    public function save(string $key, string $variableKey, $data) : void
    {
        $cacheFilePaths = $this->getCacheFilePaths($key);
        $this->smartFileSystem->mkdir($cacheFilePaths->getFirstDirectory());
        $this->smartFileSystem->mkdir($cacheFilePaths->getSecondDirectory());
        $path = $cacheFilePaths->getFilePath();
        $tmpPath = \sprintf('%s/%s.tmp', $this->directory, \RectorPrefix20211231\Nette\Utils\Random::generate());
        $errorBefore = \error_get_last();
        $exported = @\var_export(new \Rector\Caching\ValueObject\CacheItem($variableKey, $data), \true);
        $errorAfter = \error_get_last();
        if ($errorAfter !== null && $errorBefore !== $errorAfter) {
            throw new \Rector\Core\Exception\Cache\CachingException(\sprintf('Error occurred while saving item %s (%s) to cache: %s', $key, $variableKey, $errorAfter['message']));
        }
        // for performance reasons we don't use SmartFileSystem
        \RectorPrefix20211231\Nette\Utils\FileSystem::write($tmpPath, \sprintf("<?php declare(strict_types = 1);\n\nreturn %s;", $exported));
        $renameSuccess = @\rename($tmpPath, $path);
        if ($renameSuccess) {
            return;
        }
        @\unlink($tmpPath);
        if (\DIRECTORY_SEPARATOR === '/' || !\file_exists($path)) {
            throw new \Rector\Core\Exception\Cache\CachingException(\sprintf('Could not write data to cache file %s.', $path));
        }
    }
    public function clean(string $key) : void
    {
        $cacheFilePaths = $this->getCacheFilePaths($key);
        $this->processRemoveCacheFilePath($cacheFilePaths);
        $this->processRemoveEmptyDirectory($cacheFilePaths->getSecondDirectory());
        $this->processRemoveEmptyDirectory($cacheFilePaths->getFirstDirectory());
    }
    public function clear() : void
    {
        $this->smartFileSystem->remove($this->directory);
    }
    private function processRemoveCacheFilePath(\Rector\Caching\ValueObject\CacheFilePaths $cacheFilePaths) : void
    {
        $filePath = $cacheFilePaths->getFilePath();
        if (!$this->smartFileSystem->exists($filePath)) {
            return;
        }
        $this->smartFileSystem->remove($filePath);
    }
    private function processRemoveEmptyDirectory(string $directory) : void
    {
        if (!$this->smartFileSystem->exists($directory)) {
            return;
        }
        if ($this->isNotEmptyDirectory($directory)) {
            return;
        }
        $this->smartFileSystem->remove($directory);
    }
    private function isNotEmptyDirectory(string $directory) : bool
    {
        // FilesystemIterator will initially point to the first file in the folder - if there are no files in the folder, valid() will return false
        $filesystemIterator = new \FilesystemIterator($directory);
        return $filesystemIterator->valid();
    }
    private function getCacheFilePaths(string $key) : \Rector\Caching\ValueObject\CacheFilePaths
    {
        $keyHash = \sha1($key);
        $firstDirectory = \sprintf('%s/%s', $this->directory, \substr($keyHash, 0, 2));
        $secondDirectory = \sprintf('%s/%s', $firstDirectory, \substr($keyHash, 2, 2));
        $filePath = \sprintf('%s/%s.php', $secondDirectory, $keyHash);
        return new \Rector\Caching\ValueObject\CacheFilePaths($firstDirectory, $secondDirectory, $filePath);
    }
}
