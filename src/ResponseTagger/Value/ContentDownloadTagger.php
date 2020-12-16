<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger\Value;

use eZ\Bundle\EzPublishIOBundle\BinaryStreamResponse;
use EzSystems\PlatformHttpCacheBundle\Handler\ContentTagInterface;

class ContentDownloadTagger extends AbstractValueTagger
{
    public const DOWNLOAD_CONTENT_ID_HEADER = 'ezdownload-content-id';

    public function tag($value)
    {
        if (
            !$value instanceof BinaryStreamResponse
            || !$value->headers->has(self::DOWNLOAD_CONTENT_ID_HEADER)
        ) {
            return;
        }

        $contentId = $value->headers->get(self::DOWNLOAD_CONTENT_ID_HEADER);
        $this->responseTagger->addTags([
            ContentTagInterface::CONTENT_PREFIX . $contentId,
        ]);
        $value->headers->remove(self::DOWNLOAD_CONTENT_ID_HEADER);
    }
}
