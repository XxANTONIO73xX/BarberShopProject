<?php

declare (strict_types=1);
namespace Rector\Core\FileSystem;

use Rector\Caching\UnchangedFilesFilter;
use Rector\Core\Util\StringUtils;
use Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use Symplify\SmartFileSystem\SmartFileInfo;
final class PhpFilesFinder
{
    /**
     * @readonly
     * @var \Rector\Core\FileSystem\FilesFinder
     */
    private $filesFinder;
    /**
     * @readonly
     * @var \Rector\Caching\UnchangedFilesFilter
     */
    private $unchangedFilesFilter;
    public function __construct(\Rector\Core\FileSystem\FilesFinder $filesFinder, \Rector\Caching\UnchangedFilesFilter $unchangedFilesFilter)
    {
        $this->filesFinder = $filesFinder;
        $this->unchangedFilesFilter = $unchangedFilesFilter;
    }
    /**
     * @param string[] $paths
     * @return SmartFileInfo[]
     */
    public function findInPaths(array $paths) : array
    {
        $phpFileInfos = $this->filesFinder->findInDirectoriesAndFiles($paths);
        $suffixRegexPattern = \Rector\Core\ValueObject\StaticNonPhpFileSuffixes::getSuffixRegexPattern();
        // filter out non-PHP files
        foreach ($phpFileInfos as $key => $phpFileInfo) {
            $pathName = $phpFileInfo->getPathname();
            /**
             *  check .blade.php early so next .php check in next if can be skipped
             */
            if (\substr_compare($pathName, '.blade.php', -\strlen('.blade.php')) === 0) {
                unset($phpFileInfos[$key]);
                continue;
            }
            /**
             * obvious
             */
            if (\substr_compare($pathName, '.php', -\strlen('.php')) === 0) {
                continue;
            }
            /**
             * only check with regex when needed
             */
            if (\Rector\Core\Util\StringUtils::isMatch($pathName, $suffixRegexPattern)) {
                unset($phpFileInfos[$key]);
            }
        }
        return $this->unchangedFilesFilter->filterAndJoinWithDependentFileInfos($phpFileInfos);
    }
}
