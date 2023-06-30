<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Contentwarehouse;

class PhotosHdrMetadataGainmap extends \Google\Model
{
  /**
   * @var bool
   */
  public $adobeHdr;
  /**
   * @var bool
   */
  public $googleHdr;

  /**
   * @param bool
   */
  public function setAdobeHdr($adobeHdr)
  {
    $this->adobeHdr = $adobeHdr;
  }
  /**
   * @return bool
   */
  public function getAdobeHdr()
  {
    return $this->adobeHdr;
  }
  /**
   * @param bool
   */
  public function setGoogleHdr($googleHdr)
  {
    $this->googleHdr = $googleHdr;
  }
  /**
   * @return bool
   */
  public function getGoogleHdr()
  {
    return $this->googleHdr;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(PhotosHdrMetadataGainmap::class, 'Google_Service_Contentwarehouse_PhotosHdrMetadataGainmap');
